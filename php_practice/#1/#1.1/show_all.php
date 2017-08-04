<?php

function user_all($id) {
  global $pdo;
  $sql = "SELECT * FROM user_info";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $tmpl = tmp_read('data');

  $user_data = "";
  while($info = $stmt->fetch()) {
    $tmple = $tmpl;
    $tmple = str_replace('!name!', $info['name'], $tmple);
    $tmple = str_replace('!tel!', $info['tel'], $tmple);
    $tmple = str_replace('!email!', $info['email'], $tmple);
    $tmple = str_replace('!user_id!', $info['user_id'], $tmple);
    $tmple = str_replace('!id!', $info['user_id'], $tmple);
    $user_data .= $tmple;
  }

  $tmpl = tmp_read('user_all');

  $tmpl = str_replace('!id!', $id, $tmpl);
  $tmpl = str_replace('!user_data!', $user_data, $tmpl);

  if (array_key_exists('id', $_GET)) {
    $data = $_GET['id'];

    $sql = "SELECT user_info.name, sale_info.date, content_info.name, sale_info.number FROM sale_info INNER JOIN content_info ON sale_info.content_id = content_info.content_id INNER JOIN user_info ON sale_info.user_id = user_info.user_id WHERE user_info.user_id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $data);
    $stmt->execute();

    $tmple_user_history = tmp_read('sale_date');

    $user_history = "";
    while($info = $stmt->fetch()) {
      $tmpl_user_history = $tmple_user_history;
      $tmpl_user_history = str_replace('!date!', $info['date'], $tmpl_user_history);
      $tmpl_user_history = str_replace('!name!', $info['name'], $tmpl_user_history);
      $tmpl_user_history = str_replace('!number!', $info['number'], $tmpl_user_history);
      $name = $info[0];
      $user_history .= $tmpl_user_history;
    }

    $tmpl = str_replace('!name!', $name, $tmpl);
    $tmpl = str_replace('!user_history!', $user_history, $tmpl);

  } else {

    $tmpl = str_replace('!name!', 'ユーザー', $tmpl);
    $tmpl = str_replace('!user_history!', '', $tmpl);

  }

  print $tmpl;
  exit;
}

function sale_all($id, $ave_data) {
  global $pdo;
  $sql = "SELECT sale_info.date, sum(sale_info.number * content_info.price) AS sale FROM sale_info INNER JOIN content_info ON sale_info.content_id = content_info.content_id GROUP BY sale_info.date";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $tmpl = tmp_read('sale_data');

  $sale_data = "";
  $all = "";
  while($info = $stmt->fetch()) {
    $tmple = $tmpl;
    $tmple = str_replace('!date!', $info['date'], $tmple);
    $tmple = str_replace('!sale!', $info['sale'], $tmple);
    $sale_data .= $tmple;
    $all += $info['sale'];
  }

  $tmpl_sale_all = tmp_read('sale_all');

  if(array_key_exists('date', $_GET)) {
    $date = $_GET['date'];

    $sql = "SELECT sale_info.date, content_info.name, sale_info.number FROM sale_info INNER JOIN content_info ON sale_info.content_id = content_info.content_id WHERE sale_info.date = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $date);
    $stmt->execute();

    $tmple_sale_date = tmp_read('sale_date');

    $sale_date = "";
    while($info = $stmt->fetch()) {
      $tmpl_sale_date = $tmple_sale_date;
      $tmpl_sale_date = str_replace('!date!', $info['date'], $tmpl_sale_date);
      $tmpl_sale_date = str_replace('!name!', $info['name'], $tmpl_sale_date);
      $tmpl_sale_date = str_replace('!number!', $info['number'], $tmpl_sale_date);
      $sale_date .= $tmpl_sale_date;
      $date = $info['date'];
    }
    $tmpl_sale_all = str_replace('!date!', $date, $tmpl_sale_all);
    $tmpl_sale_all = str_replace('!sale_date!', $sale_date, $tmpl_sale_all);
  } else {
    $tmpl_sale_all = str_replace('!date!', '当日', $tmpl_sale_all);
    $tmpl_sale_all = str_replace('!sale_date!', '', $tmpl_sale_all);
  }

  $tmpl_sale_all = str_replace('!id!', $id, $tmpl_sale_all);
  $tmpl_sale_all = str_replace('!sale_data!', $sale_data, $tmpl_sale_all);
  $tmpl_sale_all = str_replace('!all!', $all, $tmpl_sale_all);
  $tmpl_sale_all = str_replace('!ave_data!', $ave_data, $tmpl_sale_all);

  print $tmpl_sale_all;
  exit;
}

function stock_all($id) {
  global $pdo;

  $sql = "SELECT content_info.name, content_info.stock - SUM(sale_info.number) AS stock FROM sale_info INNER JOIN content_info ON sale_info.content_id = content_info.content_id GROUP BY content_info.content_id";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $tmpl = tmp_read('stock_data');
  $stock_data = "";
  while($info = $stmt->fetch()) {
    $tmple = $tmpl;
    $tmple = str_replace('!name!', $info['name'], $tmple);
    $tmple = str_replace('!stock!', $info['stock'], $tmple);
    $stock_data .= $tmple;
  }

  $tmpl = tmp_read('stock_all');
  $tmpl = str_replace('!id!', $id, $tmpl);
  $tmpl = str_replace('!stock_data!', $stock_data, $tmpl);

  print $tmpl;
  exit;
}


function average($id, $in) {
  global $pdo;

  $sql = 'SELECT DATEDIFF(?, ?)';
  $stmt = $pdo->prepare($sql);
  $data = array( $in['end_date'], $in['start_date'] );
  $stmt->execute($data);

  $datedif = $stmt->fetch();

  $sql = "SELECT content_info.name, SUM(sale_info.number) AS number FROM sale_info INNER JOIN content_info ON sale_info.content_id = content_info.content_id WHERE sale_info.date >= ? AND sale_info.date <= ? GROUP BY content_info.name";

  $stmt = $pdo->prepare($sql);
  $data = array( $in['start_date'], $in['end_date'] );
  $stmt->execute($data);

  $tmpl = tmp_read('average');

  $ave_data = "";
  while($info = $stmt->fetch()) {
    $ave = $info['number'] / abs($datedif[0]);
    $ave = sprintf('%0.2f', $ave);

    $tmple = $tmpl;
    $tmple = str_replace('!name!', $info['name'], $tmple);
    $tmple = str_replace('!ave!', $ave, $tmple);
    $ave_data .= $tmple;
  }

  return $ave_data;
}

