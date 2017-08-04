<?php
function getDb() {
  $dsn = 'mysql:host=localhost; dbname=booksample; charset=utf8';
  $usr = 'testuser';
  $pass = 'testpass';

  $db = new PDO($dsn, $usr, $pass);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $db;
}