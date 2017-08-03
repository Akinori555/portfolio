<?php
require_once '../../DbManager.php';
require_once '../../Encode.php';
require_once 'show_all.php';
require_once 'insert.php';
require_once 'order.php';

// try {

$pdo = getDb();

session_start();
if(!empty($_SESSION['id'])) {
  $id = $_SESSION['id'];
  $pass = $_SESSION['pass'];
  if (in_array('change', $_POST)) {
    $in = parse_form();
    change($id, $in['id'], $in);
  }
  if (in_array('insert', $_POST)) {
    $in = parse_form();
    insert($id, $in);
  }
  if (in_array('average', $_POST)) {
    $in = parse_form();
    $ave_data = average($id, $in);
    sale_all($id, $ave_data);
  }
  if (in_array('order_conf', $_POST)) {
    $in = parse_form();
    order_conf($id, $in);
  } else if (in_array('order_send', $_POST)) {
    $in = parse_form();
    order_send($id, $in);
  }

  if (!isset($_GET['mode'])) {login($id, $pass);}
  switch ($_GET['mode']) {
    case 'logout':
      logout();
      break;
    case 'edit':
      edit($id, $pass);
      break;
    case 'user_all':
      user_all($id);
      break;
    case 'sale_all':
      sale_all($id, null);
      break;
    case 'stock_all':
      stock_all($id);
      break;
    case 'insert':
      insert_form($id);
      break;
    case 'order':
      order_form($id);
      break;
    default:
      login($id, $pass);
  }
}

if(!empty($id)) {
  login($id, $pass);
}
if(empty($_POST['mode']) && empty($_GET['mode'])) {
  login_html();
}
if(isset($_POST['mode'])) {
  $in = parse_form();
  $mode = $in['mode'];
  login($in['id'], $in['pass']);
}


function parse_form() {
  global $in;
  if(isset($_POST['mode'])) { $post = $_POST; }
  if(isset($_GET['mode'])) { $post = $_GET; }
  foreach($post as $key => $val) {
    if(is_array($val)) {
      $val = array_shift($val);
    }
    e($val);
    $in[$key] = $val;
  }
  return $in;
}

function login($id, $pass) {
  if($id == null) { error('IDを入力してください'); }
  if($pass == null) { error('PASSを入力してください'); }
  global $pdo;

  $sql = "SELECT * FROM staff_info WHERE user_id = ? AND pass = ?";
  $stmt = $pdo->prepare($sql);
  $user_data = array($id, $pass);
  $stmt->execute($user_data);

  $user = '';
  while($info = $stmt->fetch()) {
    $user = $info['name'];
    $tel = $info['tel'];
    $email = $info['email'];
    $user_id = $info['user_id'];
    $user_pass = $info['pass'];
  }

  if ($user == null) { error('正しいIDを入力してください。'); }
  if ($user_id == $id) {
    $_SESSION['id'] = $user_id;
    $_SESSION['pass'] = $user_pass;
  }

  $tmpl = tmp_read('staff');
  $tmpl = str_replace('!name!', $user, $tmpl);
  $tmpl = str_replace('!tel!', $tel, $tmpl);
  $tmpl = str_replace('!email!', $email, $tmpl);
  $tmpl = str_replace('!id!', $user_id, $tmpl);
  $tmpl = str_replace('!pass!', $user_pass, $tmpl);

  print $tmpl;
  exit;
}

function login_html() {
  $tmpl = tmp_read('admin');
  print $tmpl;
  exit;
}

function logout() {
  $tmpl = tmp_read('logout');
  $_SESSION = [];
  session_destroy();
  print $tmpl;
  exit;
}

function edit($id, $pass) {
  global $pdo;
  $sql = "SELECT * FROM staff_info WHERE user_id = ? AND pass = ?";
  $stmt = $pdo->prepare($sql);
  $user_data = array($id, $pass);
  $stmt->execute($user_data);

  while($info = $stmt->fetch()) {
    $user = $info['name'];
    $tel = $info['tel'];
    $email = $info['email'];
    $user_id = $info['user_id'];
    $user_pass = $info['pass'];
  }

  $tmpl = tmp_read('edit');

  $tmpl = str_replace('!name!', $user, $tmpl);
  $tmpl = str_replace('!tel!', $tel, $tmpl);
  $tmpl = str_replace('!email!', $email, $tmpl);
  $tmpl = str_replace('!id!', $user_id, $tmpl);
  $tmpl = str_replace('!pass!', $user_pass, $tmpl);

  print $tmpl;

  exit;
}

function change($id_old, $id_new, $in) {
  global $pdo;
  $sql = "SELECT user_id FROM staff_info";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  while($info = $stmt->fetch()) {
    if($id_new == $info['user_id']) { error('すでに登録済みのIDです。'); }
  }

  $sql = "UPDATE staff_info SET user_id = ?, pass = ?, name = ?, tel = ?, email = ? WHERE user_id = ?";
  $stmt = $pdo->prepare($sql);
  $user_data = array($in['id'], $in['pass'], $in['name'], $in['tel'], $in['email'], $id_old);
  $stmt->execute($user_data);

  $tmpl = tmp_read('change');

  print $tmpl;
  $_SESSION = [];
  session_destroy();

  exit;
}



function error($err) {
  $msg = $err;
  $tmpl = tmp_read('error');
  $tmpl = str_replace('!message!', $msg, $tmpl);

  print $tmpl;
  exit;
}

function tmp_read($page) {
  $conf = fopen("tmpl/{$page}.tmpl", 'r') or die;
  $size = filesize("tmpl/{$page}.tmpl");
  $tmpl = fread($conf, $size);
  fclose($conf);

  return $tmpl;
}


// } catch (PDOException $e) {
  // error($e->getMessage());
  // print "例外メッセージ：{$e->getMessage()}";
// }


