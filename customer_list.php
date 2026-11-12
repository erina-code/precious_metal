<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

try{
  $dbh = db_open();
  $sql = 'SELECT * FROM customers';
  $stmt = $dbh -> prepare($sql);
  $stmt -> execute();
?>

<table border="1">
  <tr>
    <th>顧客コード</th>
    <th>登録日</th>
    <th>顧客氏名</th>
    <th>電話番号</th>
    <th>住　所</th>
    <th>生年月日</th>
    <th>備　考</th>
    <th>更　新</th>
    <th>削　除</th>
  </tr>
  <?php while($row = $stmt -> fetch()): ?>
  <tr>
    <td><?= str2html($row['customer_id']); ?></td>
    <td><?= str2html((string)$row['created_at']); ?></td>
    <td><?= str2html($row['customer_name']); ?></td>
    <td><?= str2html($row['tel']); ?></td>
    <td><?= str2html($row['address']); ?></td>
    <td><?= str2html($row['birth_date'] ?? ''); ?></td>
    <td><?= str2html($row['remarks']); ?></td>
    <td>
      <a href="customer_edit.php?customer_id=<?= str2html((string)$row['customer_id']); ?>">更新</a>
    </td>
    <td>
      <a href="customer_delete.php?customer_id=<?= str2html((string)$row['customer_id']); ?>">削除</a>
    </td>
  </tr>
  <?php endwhile; ?>
</table>
<p>
  <a href="customer_add.php">顧客登録へ戻る</a>
</p>
<p>
  <a href="purchase_list.php">買取情報一覧</a>
</p>

<?php
} catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}
?>
</body>
</html>