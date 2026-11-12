<?php
require_once __DIR__ . '/inc/functions.php';

$purchase_id = $_POST['purchase_id'] ?? '';
$customer_id = $_POST['customer_id'] ?? '';
$purchase_date = $_POST['purchase_date'] ?? '';
$total_amount = $_POST['total_amount'] ?? '';
$status = $_POST['status'] ?? '';

require_once __DIR__ . '/inc/purchase_error_check.php';

include __DIR__ . '/inc/header.php';

try{
  $dbh = db_open();

  $sql = 'UPDATE purchases SET customer_id=:customer_id, purchase_date=:purchase_date, total_amount=:total_amount, status=:status WHERE purchase_id=:purchase_id';

  $stmt = $dbh -> prepare($sql);

  $stmt -> bindParam(':purchase_id', $purchase_id, PDO::PARAM_INT);
  $stmt -> bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
  $stmt -> bindParam(':purchase_date', $purchase_date, PDO::PARAM_STR);
  $stmt -> bindParam(':total_amount', $total_amount, PDO::PARAM_INT);
  $stmt -> bindParam(':status', $status, PDO::PARAM_STR);

  $stmt -> execute();

  echo '<p>更新が完了しました。</p>';
  echo '<p><a href="purchase_list.php">買取情報一覧</a></p>';

}catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}
