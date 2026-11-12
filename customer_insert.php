<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';
include __DIR__ . '/inc/error_check.php';

$customer_name = $_POST['customer_name'];
$tel = $_POST['tel'] ?? '';
$address = $_POST['address'] ?? '';
$birth_date = $_POST['birth_date'] ?? '';
if($birth_date === ''){
  $birth_date = null;
}
$remarks = $_POST['remarks'] ?? '';

try{
  $dbh = db_open();

  $created_at = date('Y-m-d');

  $sql = 'INSERT INTO customers(created_at, customer_name, tel, address, birth_date, remarks) VALUES (:created_at, :customer_name, :tel, :address, :birth_date, :remarks)';

  $stmt = $dbh -> prepare($sql);

  $stmt -> bindParam(':created_at', $created_at, PDO::PARAM_STR);
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

  echo '<h1>顧客登録完了</h1>';
  echo '<p>顧客登録完了しました。</p>';
  echo '<p><a href="customer_list.php">顧客一覧へ戻る</a></p>';
} catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}
?>
</body>
</html>