<?php
require_once __DIR__ . '/functions.php';

if(empty($item_name_value)){
  echo '<p>品名が入力されていません。</p>';
  exit;
}elseif(mb_strlen($item_name_value) > 30){
  echo '<p>品名は30文字以内で入力してください。</p>';
  exit;
}

if(empty($metal_type_value)){
  echo '<p>金属種類が入力されていません。</p>';
  exit;
}elseif(mb_strlen($metal_type_value) > 20){
  echo '<p>金属種類は20文字以内で入力してください。</p>';
  exit;
}

if(empty($purity_value)){
  echo '<p>品位が入力されていません。</p>';
  exit;
}elseif(mb_strlen($purity_value) > 20){
  echo '<p>品位は20文字以内で入力してください。</p>';
  exit;
}

if(!is_numeric($weight_value)){
  echo '<p>重量は数値で入力してください。</p>';
  exit;
}elseif($weight_value <= 0){
  echo '<p>重量は0より大きい値を入力してください。</p>';
  exit;
}

if(preg_match('/\.\d{2,}/', $weight_value)){
  echo '<p>重量は小数点以下1桁まで入力してください。</p>';
  exit;
}

if(empty($unit_price_value) && $unit_price_value !== '0'){
  echo '<p>単価が入力されていません。</p>';
  exit;
}elseif(!is_numeric($unit_price_value)){
  echo '<p>単価は数値で入力してください。</p>';
  exit;
}elseif($unit_price_value <= 0){
  echo '<p>単価は0より大きい値を入力してください。</p>';
  exit;
}

if(preg_match('/\.\d{1,}/', $unit_price_value)){
  echo '<p>単価に小数点は使用できません。</p>';
  exit;
}

if(!check_html_tag($item_name_value)){
  echo '<p>HTMLタグは入力できません。</p>';
  exit;
} elseif(!check_html_tag($metal_type_value)){
  echo '<p>HTMLタグは入力できません。</p>';
  exit;
} elseif(!check_html_tag($purity_value)){
  echo '<p>HTMLタグは入力できません。</p>';
  exit;
} elseif(!check_html_tag($weight_value)){
  echo '<p>HTMLタグは入力できません。</p>';
  exit;
} elseif(!check_html_tag($unit_price_value)){
  echo '<p>HTMLタグは入力できません。</p>';
  exit;
}