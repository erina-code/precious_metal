<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

try{
  if(empty($_GET['customer_id'])){
    echo '<p>顧客コードを指定してください。</p>';
    exit;
  }else{
    $customer_id = $_GET['customer_id'];
  }

  $dbh = db_open();

  $sql = 'DELETE FROM customers WHERE customer_id=:customer_id';

  $stmt = $dbh -> prepare($sql);

  $stmt -> bindParam(':customer_id', $customer_id, PDO::PARAM_INT);

  $stmt -> execute();

// 本当に削除しますかの確認画面入れる

  if($stmt -> rowCount() > 0){
    echo '<p>削除完了</p>';
  }else{
    echo '<p>削除する顧客データが見つかりませんでした。</p>';
  }

  echo '<p><a href="customer_list.php">顧客情報一覧に戻る</a></p>';
}catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}
?>
</body>
</html>