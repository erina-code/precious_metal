<?php
require_once __DIR__ . '/inc/functions.php';

$customer_id = $_GET['customer_id'] ?? '';

if(empty($customer_id)){
  echo '<p>顧客IDを指定してください。</p>';
  exit;
}

header('Location: purchase_register.php?customer_id='. urlencode($customer_id));
exit;