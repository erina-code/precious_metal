<?php
require_once __DIR__ . '/db_config.php';

function str2html(string $string):string{
  return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function check_html_tag(string $string):bool{
  return preg_match('/<[^>]*>/', $string) === 0;
}

function db_open():PDO{
  $opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
  ];

  $dbh = new PDO('mysql:host=localhost;dbname=precious_metal_db', DB_USER, DB_PASSWORD, $opt);

  return $dbh;
}