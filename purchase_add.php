<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

try{
  $dbh = db_open();

  $purchase_name = $_GET['purchase_name'] ?? '';
  $tel = $_GET['tel'] ?? '';
  $birth_date = $_GET['birth_date'] ?? '';

  $sql = 'SELECT * FROM customers';

  $search_name = '%'. $purchase_name. '%';
  $search_tel = '%'. $tel. '%';
  $search_birth_date = $birth_date;

  $where = [];

  if($purchase_name !== ''){
    $where[] = 'customer_name LIKE :customer_name';
  }

  if($tel !== ''){
    $where[] = 'tel LIKE :tel';
  }

  if($birth_date !== ''){
    $where[] = 'birth_date = :birth_date';
  }

  if(count($where) > 0){
    $sql .= ' WHERE ';
    $sql .= implode(' AND ', $where);
  }

  $stmt = $dbh -> prepare($sql);

  if($purchase_name !== ''){
    $stmt -> bindParam(':customer_name', $search_name, PDO::PARAM_STR);
  }

  if($tel !== ''){
    $stmt -> bindParam(':tel', $search_tel, PDO::PARAM_STR);
  }
  if($birth_date !== ''){
    $stmt -> bindParam(':birth_date', $search_birth_date, PDO::PARAM_STR);
  }

  $stmt -> execute();

  $customers = $stmt -> fetchAll();

  if(count($customers) == 0){
      echo '<p>該当するお客様は見つかりませんでした。</p>';
    }
?>

<h1>買取情報登録</h1>
<table class="purchase_search_table" border="1">
  <tr>
    <th>顧客ID</th>
    <th>氏　名</th>
    <th>電話番号</th>
    <th>生年月日</th>
    <th>選　択</th>
  </tr>

<?php foreach($customers as $customer): ?>
  <tr>
    <td><?= str2html($customer['customer_id']); ?></td>
    <td><?= str2html($customer['customer_name']); ?></td>
    <td><?= str2html($customer['tel'] ?? ''); ?></td>
    <td><?= str2html($customer['birth_date'] ?? ''); ?></td>
    <td>
      <form action="purchase_select.php" method="get">
      <input type="hidden" name="customer_id" value="<?= str2html($customer['customer_id']); ?>">
      <button type="submit">選択</button>
      </form>
    </td>
  </tr>
<?php endforeach; ?>
</table>

  <form action="purchase_add.php" method="get">
    <p>
      <label for="purchase_name">氏名：</label>
      <input type="text" id="purchase_name" name="purchase_name" value="<?= str2html($purchase_name); ?>">
    </p>
    <p>
      <label for="tel">電話番号：</label>
      <input type="tel" id="tel" name="tel" value="<?= str2html($tel); ?>">
    </p>
    <p>
      <label for="birth_date">生年月日：</label>
      <input type="date" id="birth_date" name="birth_date" value="<?= str2html($birth_date); ?>">
    </p>
    <p>
      <button type="submit">検索</button>
    </p>
</form>

<?php
}catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}
?>
