<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

$purchase_id = $_GET['purchase_id'] ?? '';

if(empty($purchase_id)){
  echo '<p>買取受付IDが指定されていません。</p>';
  exit;
}

try{
  $dbh = db_open();

  $sql = 'SELECT * FROM purchases WHERE purchase_id=:purchase_id';

  $stmt = $dbh -> prepare($sql);

  $stmt -> bindParam(':purchase_id', $purchase_id, PDO::PARAM_STR);

  $stmt -> execute();

  $row = $stmt ->fetch();
  if(!$row){
    echo '<p>指定された買取情報が見つかりません。</p>';
    exit;
  }
?>

<h1>買取情報更新</h1>
<form action="purchase_update.php" method="post">
  <p>
    <label for="purchase_id">買取受付ID：</label>
    <input type="text" id="purchase_id" name="purchase_id" value="<?= str2html($purchase_id); ?>" readonly>
  </p>
  <p>
    <label for="customer_id">顧客ID：</label>
    <input type="text" id="customer_id" name="customer_id" value="<?= str2html($row['customer_id']); ?>" readonly>
  </p>
  <p>
    <label for="purchase_date">買取日：</label>
    <input type="date" id="purchase_date" name="purchase_date" value="<?= str2html($row['purchase_date']); ?>">
  </p>
  <p>
    <label for="total_amount">買取合計金額：</label>
    <input type="number" id="total_amount" name="total_amount" min="0" value="<?= str2html($row['total_amount']); ?>">
  </p>
  <p>
    <label for="status">状　態：</label>
    <select name="status" id="status">
      <option value="受付中" <?php if($row['status'] === '受付中'){
        echo 'selected';
      } ?>>受付中</option>
      <option value="買取成約" <?php if($row['status'] === '買取成約'){
        echo 'selected';
      } ?>>買取成約</option>
      <option value="買取不成約" <?php if($row['status'] === '買取不成約'){
        echo 'selected';
      } ?>>買取不成約</option>
    </select>
  </p>
  <p>
    <button type="submit">更新</button>
  </p>
</form>

<p>
  <a href="purchase_list.php">買取情報一覧</a>
</p>

<?php
}catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}