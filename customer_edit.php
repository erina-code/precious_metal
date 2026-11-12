<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

try{
  if(empty($_GET['customer_id'])){
  echo '<p>顧客コードを指定してください。</p>';
  exit;
  }
  $customer_id = $_GET['customer_id'];


  $dbh = db_open();

  $sql = 'SELECT * FROM customers WHERE customer_id=:customer_id';

  $stmt = $dbh -> prepare($sql);

  $stmt -> bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
  $stmt -> execute();

  $result = $stmt -> fetch(PDO::FETCH_ASSOC);

  if($result === false){
    echo '<p>顧客データが見つかりませんでした。</p>';
    exit;
  }
?>

<h1>顧客情報更新</h1>
<form action="customer_update.php" method="post">
  <p>
    <label for="customer_id">顧客コード：</label>
    <input type="text" id="customer_id" name="customer_id" value="<?= str2html((string)$result['customer_id']); ?>" readonly>
  </p>
  <p>
    <label for="customer_name">顧客氏名<span class="required">*</span>：
    </label>
    <input type="text" id="customer_name" name="customer_name" value="<?= str2html($result['customer_name']); ?>" required>
  </p>
  <p>
    <label for="tel">電話番号：</label>
    <input type="text" id="tel" name="tel" value="<?= str2html($result['tel'] ?? ''); ?>">
  </p>
  <p>
    <label for="address">住所：</label>
    <input type="text" id="address" name="address" value="<?= str2html($result['address'] ?? ''); ?>">
  </p>
  <p>
    <label for="birth_date">生年月日：</label>
    <input type="date" id="birth_date" name="birth_date" value="<?= str2html($result['birth_date'] ?? ''); ?>">
  </p>
  <p>
    <label for="remarks">備　考：</label>
    <textarea name="remarks" id="remarks"><?= str2html($result['remarks'] ?? ''); ?></textarea>
  </p>
  <p>
    <input type="submit" value="更新">
  </p>
</form>

<?php
}catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}
?>
</body>
</html>