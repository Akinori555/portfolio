<?php
function insert_form($id) {
  $tmpl = tmp_read('insert_form');
  $tmpl = str_replace('!id!', $id, $tmpl);

  print $tmpl;
  exit;
}

function insert($id, $in) {
  global $pdo;
  // if( !isset($in['date']) || !isset($in['name']) || !isset($in['content']) || !isset($in['number']) ) {
  //   error('未入力項目があります。');
  // }
  if( trim($in['date']) === "" ||  trim($in['name']) === "" ||  trim($in['content']) === "" ||  trim($in['number']) === "" ) {
    error('未入力項目があります。');
  }

  if ( !preg_match('/\d{4}-\d{2}-\d{2}/', $in['date']) ) {
    error('購入日の記述が違います。');
  }

  $date = $in['date'];
  $name = $in['name'];
  $content = $in['content'];
  $number = $in['number'];

  $sql = "SELECT user_id FROM user_info WHERE name = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(1, $name);
  $stmt->execute();

  $info = $stmt->fetch();
  if($info === false) { error('正しい名前で入力してください。'); }
  $user_id = $info['user_id'];

  $sql = "SELECT content_id FROM content_info WHERE name = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(1, $content);
  $stmt->execute();

  $info = $stmt->fetch();
  $content_id = $info['content_id'];

  $sql = "INSERT INTO sale_info('content_id', 'number', 'user_id', 'date') VALUES(?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $data = array($content_id, $number, $user_id, $date);
  $stmt->execute($data);

  $tmpl = tmp_read('insert');
  $tmpl = str_replace('!id!', $id, $tmpl);

  print $tmpl;
  exit;
}