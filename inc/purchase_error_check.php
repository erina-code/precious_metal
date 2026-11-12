<?php
require_once __DIR__ . '/functions.php';

foreach($_POST as $value){
  if(is_string($value) && !check_html_tag($value)){
    echo '<p>HTMLタグは入力できません。</p>';
    exit;
  }
}

if(empty($_POST['customer_id'])){
  echo '<p>顧客IDが指定されていません。</p>';
  exit;
}

if(empty($_POST['purchase_date'])){
  echo '<p>買取日が指定されていません。</p>';
  exit;
}

if(!in_array($_POST['status'] ?? '', ['受付中', '買取成約', '買取不成約'], true)){
  echo '<p>状態の指定が正しくありません。</p>';
  exit;
}
