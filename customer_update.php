<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

$customer_id = (int)($_POST['customer_id'] ?? 0);
$customer_name = $_POST['customer_name'] ?? '';
$tel = $_POST['tel'] ?? '';
$address = $_POST['address'] ?? '';
$birth_date = $_POST['birth_date'] ?? '';
$remarks = $_POST['remarks'] ?? '';

require_once __DIR__ . '/inc/error_check.php';

try{
  $dbh = db_open();

  $sql = 'UPDATE customers SET customer_name=:customer_name, tel=:tel, address=:address, birth_date=:birth_date, remarks=:remarks WHERE customer_id=:customer_id';

  $stmt = $dbh -> prepare($sql);

  $stmt -> bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
  $stmt -> bindParam(':customer_name', $customer_name, PDO::PARAM_STR);
  $stmt -> bindParam(':tel', $tel, PDO::PARAM_STR);
  $stmt -> bindParam(':address', $address, PDO::PARAM_STR);
  if($birth_date === ''){
    $stmt -> bindValue(':birth_date', null, PDO::PARAM_NULL);
  }else{
    $stmt -> bindValue(':birth_date', $birth_date, PDO::PARAM_STR);
  }
  $stmt -> bindParam(':remarks', $remarks, PDO::PARAM_STR);

  $stmt -> execute();

  echo '<p>更新完了</p>';
  echo '<p><a href="customer_list.php">顧客情報一覧へ戻る</a></p>';

}catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}
?>
</body>
</html>