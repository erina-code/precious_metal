<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

try{
  $dbh = db_open();

  $sql = 'SELECT * FROM purchases INNER JOIN customers ON purchases.customer_id=customers.customer_id';

  $stmt = $dbh -> prepare($sql);

  $stmt -> execute();
?>

<h1>買取情報一覧</h1>
<table border="1">
  <tr>
    <th>買取受付ID</th>
    <th>買取日</th>
    <th>顧客ID</th>
    <th>顧客氏名</th>
    <th>買取合計金額</th>
    <th>状　態</th>
    <th>更　新</th>
    <th>削　除</th>
  </tr>
  <?php while($row = $stmt -> fetch()): ?>
  <tr>
    <td><?= str2html($row['purchase_id']); ?></td>
    <td><?= str2html($row['purchase_date']); ?></td>
    <td><?= str2html($row['customer_id']); ?></td>
    <td><?= str2html($row['customer_name']); ?></td>
    <td class="right"><?= number_format(str2html($row['total_amount'])); ?></td>
    <td><?= str2html($row['status']); ?></td>
    <td><a href="purchase_edit.php?purchase_id=<?= str2html((string)$row['purchase_id']); ?>">更新</a></td>
    <td><a href="purchase_delete.php?purchase_id=<?= str2html((string)$row['purchase_id']); ?>">削除</a></td>
  </tr>
  <?php endwhile; ?>
</table>
<p>
  <a href="purchase_add.php">買取情報を登録</a>
</p>

<?php
}catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}
?>
</body>
</html>
