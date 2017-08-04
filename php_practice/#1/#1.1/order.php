<?php
function order_form($id) {
  global $pdo;

  $sql = "SELECT content_info.name, content_info.stock - SUM(sale_info.number) AS stock FROM sale_info INNER JOIN content_info ON sale_info.content_id = content_info.content_id GROUP BY content_info.content_id";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $tmpl = tmp_read('order_form_data');
  $order_form_data = "";
  while($info = $stmt->fetch()) {
    $tmple = $tmpl;
    $tmple = str_replace('!name!', $info['name'], $tmple);
    $tmple = str_replace('!stock!', $info['stock'], $tmple);
    $order_form_data .= $tmple;
  }

  $tmpl = tmp_read('order_form');
  $tmpl = str_replace('!id!', $id, $tmpl);
  $tmpl = str_replace('!order_form_data!', $order_form_data, $tmpl);

  print $tmpl;
  exit;
}

function order_conf($id, $in) {
  global $pdo;
  $req_date = $in['req_date'];
  if( $req_date < date('Y-m-d', strtotime("+7 day")) ) {
    error('配送希望日は本日より7日以上先を指定してください。');
  }

  $sql = "SELECT content_info.name, content_info.stock - SUM(sale_info.number) AS stock FROM sale_info INNER JOIN content_info ON sale_info.content_id = content_info.content_id GROUP BY content_info.content_id";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $tmpl = tmp_read('order_conf_data');
  $order_conf_data = "";
  $oid = 0;
  while($info = $stmt->fetch()) {
    $tmple = $tmpl;
    $name = $info['name'];
    $req = $in["{$name}_num"];
    if( $req > $info['stock'] ) { error('在庫数が足りていません。'); }
    if ( $req >= 1 ) {
      $tmple = str_replace('!oid!', $oid, $tmple);
      $tmple = str_replace('!name!', $name, $tmple);
      $tmple = str_replace('!num!', $req, $tmple);
      $order_conf_data .= $tmple;
      $oid++;
    } else {
      continue;
    }
  }

  $tmpl = tmp_read('order_conf');
  $tmpl = str_replace('!order_conf_data!', $order_conf_data, $tmpl);

  $req_date = date('Y-m-d', strtotime($req_date));
  $tmpl = str_replace('!req_date!', $req_date, $tmpl);

  print $tmpl;
  exit;
}

function order_send($id, $in) {
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  global $pdo;
  $oid = 0;
  $sale_update = array();
  $sale_data = array();

  while( $in["order_{$oid}"] ) {
    $name = $in["order_{$oid}"];
    $sql = "SELECT content_id FROM content_info WHERE name = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1,$name);
    $stmt->execute();

    $info = $stmt->fetch();
    $content_id = $info['content_id'];

    $number = intval($in["{$name}_num"]);
    $date = $in['req_date'];

    $sql = "INSERT INTO sale_info(`content_id`, `number`, `user_id`, `date`) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $sql_data = array($content_id, $number, $id, $date);
    $stmt->execute($sql_data);

    $sale_data = array_merge($sale_data, array($name => $number));

    $oid++;
  }

  $to = 'youzinboo@gmail.com';
  $subject = 'PHP青果 発注完了メール';
  $sale_data_text = '';
  foreach($sale_data as $key => $val) {
    $sale_data_text .= "\t\t{$key} × {$val}\r\n";
  }
  $buy_time = date("Y-m-d H:i:s");
  $body = <<< __BODY__
以下の内容で発注を受け付けました。\n
  ユーザーID：{$id}\n
  発注日時：{$buy_time}\n
  発注内容：\n{$sale_data_text}
  配送希望日：{$date}\n
__BODY__;
  $from_name = "PHP青果";
  $from_addr = "sample@co.jp";
  $from_name_enc = mb_encode_mimeheader($from_name, 'ISO-2022-JP');
  $from = "$from_name_enc<{$from_addr}>";
  // $from = "From:".mb_encode_mimeheader("PHP青果")."<example@example.com>";
  $header = "From: $from\r\n";
  $header .= "X-Mailer: PHP 7\r\n";
  mb_send_mail($to, $subject, $body, $header);

  $tmpl = tmp_read('order_send');
  print $tmpl;

  exit;
}