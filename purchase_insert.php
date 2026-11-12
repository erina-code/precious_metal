<?php
require_once __DIR__ . '/inc/functions.php';

$customer_id = $_POST['customer_id'] ?? '';
$purchase_date = $_POST['purchase_date'] ?? '';
$status = $_POST['status'] ?? '';

require_once __DIR__ . '/inc/purchase_error_check.php';

try{
  $dbh = db_open();

  $sql = 'SELECT customer_id FROM customers WHERE customer_id=:customer_id';

  $stmt = $dbh -> prepare($sql);

  $stmt -> bindParam(':customer_id', $customer_id, PDO::PARAM_INT);

  $stmt -> execute();

  if($stmt -> fetch() === false){
    echo '<p>指定された顧客が見つかりません。</p>';
    exit;
  }

  $sql = 'INSERT INTO purchases (customer_id, purchase_date, status) VALUES (:customer_id, :purchase_date, :status)';

  $stmt = $dbh -> prepare($sql);

  $stmt -> bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
  $stmt -> bindParam(':purchase_date', $purchase_date, PDO::PARAM_STR);
  $stmt -> bindParam(':status', $status, PDO::PARAM_STR);

  $stmt -> execute();

  $purchase_id = $dbh -> lastInsertId();

  header('Location: purchase_detail_add.php?purchase_id='. urlencode($purchase_id). '&registered=1');
  exit;


}catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}
?>
</body>
</html>