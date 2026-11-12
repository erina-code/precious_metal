<?php
require_once __DIR__ . '/functions.php';

/*if (empty($_POST['customer_id'])) {
  echo '<p>顧客コードを指定してください。</p>';
  exit;
}*/

foreach($_POST as $value){
  if(is_string($value) && !check_html_tag($value)){
    echo '<p>HTMLタグは入力できません。</p>';
    exit;
  }
}

if(empty($_POST['customer_name'])){
  echo '<p>顧客名が入力されていません。</p>';
  exit;
}

if(mb_strlen($_POST['customer_name']) > 30){
  echo '<p>顧客名は30文字以内で入力してください。</p>';
  exit;
}

if(mb_strlen($_POST['tel'] ?? '') > 20){
  echo '<p>電話番号は20文字以内で入力してください。</p>';
  exit;
}

if(!empty($_POST['birth_date'])){
  $data = explode('-', $_POST['birth_date']);
  $year = (int)$data[0];
  $month = (int)$data[1];
  $day = (int)$data[2];

  if(!checkdate($month, $day, $year)){
    echo '<p>生年月日の入力が間違えています。</p>';
    exit;
    }
}

if(mb_strlen($_POST['address'] ?? '') > 50){
  echo '<p>住所は50文字以内で入力してください。</p>';
  exit;
}

if(mb_strlen($_POST['remarks'] ?? '') > 50){
  echo '<p>備考は50文字以内で入力してください。</p>';
  exit;
}