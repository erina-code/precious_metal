<?php
require_once __DIR__ . '/inc/functions.php';

$purchase_id = $_GET['purchase_id'] ?? '';

if(empty($purchase_id)){
  echo '<p>買取受付IDが指定されていません。</p>';
  exit;
}

include __DIR__ . '/inc/header.php';

try{
  $dbh = db_open();

  $sql = 'DELETE FROM purchases WHERE purchase_id=:purchase_id';

  $stmt = $dbh -> prepare($sql);

  $stmt -> bindParam(':purchase_id', $purchase_id, PDO::PARAM_INT);

  $stmt -> execute();

  echo '<p>削除完了</p>';
  echo '<p><a href="purchase_list.php">買取受付一覧</a></p>';

}catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}