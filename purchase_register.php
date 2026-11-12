<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

$customer_id = $_GET['customer_id'] ?? '';

if(empty($customer_id)){
  echo '<p>顧客IDを指定してください。</p>';
  exit;
}

try{
  $dbh = db_open();

  $sql = 'SELECT * FROM customers WHERE customer_id=:customer_id';

  $stmt = $dbh -> prepare($sql);

  $stmt ->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);

  $stmt -> execute();

  $customer = $stmt -> fetch(PDO::FETCH_ASSOC);

  if($customer === false){
    echo '<p>顧客データが見つかりませんでした。</p>';
    exit;
  }
?>

<h1>買取情報登録</h1>
<p>
  顧客ID：<?= str2html((string)$customer['customer_id']); ?>
</p>
<p>
  氏名：<?= str2html($customer['customer_name']); ?>
</p>
<p>
  電話番号：<?= str2html($customer['tel'] ?? ''); ?>
</p>
<p>
  生年月日：<?= str2html($customer['birth_date'] ?? ''); ?>
</p>

<form action="purchase_insert.php" method="post">
  <input type="hidden" name="customer_id" value="<?= str2html((string)$customer['customer_id']); ?>">
  <p>
    <label for="purchase_date">買取日：</label>
    <input type="date" id="purchase_date" name="purchase_date" required>
  </p>
  <p>
    <label for="status">状態：</label>
    <select name="status" id="status">
      <option value="受付中">受付中</option>
      <option value="買取成約">買取成約</option>
      <option value="買取不成約">買取不成約</option>
    </select>
  </p>
  <p>
    <button type="submit">買取情報を登録</button>
  </p>
</form>

<?php
}catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}
?>
</body>
</html>