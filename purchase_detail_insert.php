<?php
require_once __DIR__ . '/inc/functions.php';

$purchase_id = $_POST['purchase_id'] ?? '';

if(empty($_POST['purchase_id'])){
  echo '<p>買取受付IDが指定されていません。</p>';
  exit;
}

$item_name = $_POST['item_name'] ?? [];
$metal_type = $_POST['metal_type'] ?? [];
$weight = $_POST['weight'] ?? [];
$unit_price = $_POST['unit_price'] ?? [];

// 品位を受け取る
$gold = $_POST['gold'] ?? [];
$pt = $_POST['pt'] ?? [];
$sv = $_POST['sv'] ?? [];
$combo_gold = $_POST['combo_gold'] ?? [];
$combo_pt = $_POST['combo_pt'] ?? [];

// 明細を一件ずつ取り出す
foreach($item_name as $key => $item){
  $item_name_value = $item;
  $metal_type_value = $metal_type[$key];
  $weight_value = $weight[$key];
  $unit_price_value = $unit_price[$key];
  $amount_value = ($weight_value * $unit_price_value);

  $purity_value = '';

  if($metal_type_value === 'ゴールド'){
    $purity_value = $gold[$key];
  } elseif($metal_type_value === 'プラチナ'){
    $purity_value = $pt[$key];
  } elseif($metal_type_value === 'シルバー'){
    $purity_value = $sv[$key];
  } elseif($metal_type_value === 'コンビ'){
    $purity_value = $combo_gold[$key]. '/'.  $combo_pt[$key];
  }

  require __DIR__ . '/inc/purchase_detail_error_check.php';
}

$dbh = null;

try{
  $dbh = db_open();

  $dbh -> beginTransaction();

  $sql = 'INSERT INTO purchase_details(purchase_id, item_name, metal_type, purity, weight, unit_price, amount) VALUES (:purchase_id, :item_name, :metal_type, :purity, :weight, :unit_price, :amount)';

  $stmt = $dbh -> prepare($sql);

  // 複数明細を1件ずつ登録
  foreach($item_name as $key => $item){
    $item_name_value = $item;
    $metal_type_value = $metal_type[$key];
    $weight_value = $weight[$key];
    $unit_price_value = $unit_price[$key];
    $amount_value = ($weight_value * $unit_price_value);

    $purity_value = '';

    if($metal_type_value === 'ゴールド'){
    $purity_value = $gold[$key];
    } elseif($metal_type_value === 'プラチナ'){
    $purity_value = $pt[$key];
    } elseif($metal_type_value === 'シルバー'){
    $purity_value = $sv[$key];
    } elseif($metal_type_value === 'コンビ'){
    $purity_value = $combo_gold[$key]. '/'.  $combo_pt[$key];
    }

    $stmt -> bindParam(':purchase_id', $purchase_id, PDO::PARAM_INT);
    $stmt -> bindParam(':item_name', $item_name_value, PDO::PARAM_STR);
    $stmt -> bindParam(':metal_type', $metal_type_value, PDO::PARAM_STR);
    $stmt -> bindParam(':purity', $purity_value, PDO::PARAM_STR);
    $stmt -> bindParam(':weight', $weight_value, PDO::PARAM_STR);
    $stmt -> bindParam(':unit_price', $unit_price_value, PDO::PARAM_STR);
    $stmt -> bindParam(':amount',   $amount_value, PDO::PARAM_INT);

    $stmt -> execute();
  }

  // 複数明細の合計金額を取得する
  $sql = 'SELECT SUM(amount) FROM purchase_details WHERE purchase_id=:purchase_id';

  $stmt = $dbh -> prepare($sql);

  $stmt -> bindParam(':purchase_id', $purchase_id, PDO::PARAM_INT);

  $stmt -> execute();

  $total_amount = $stmt -> fetchColumn();

  $sql = 'UPDATE purchases SET total_amount=:total_amount WHERE purchase_id=:purchase_id';

  $stmt = $dbh -> prepare($sql);

  $stmt -> bindParam(':purchase_id', $purchase_id, PDO::PARAM_INT);
  $stmt -> bindParam(':total_amount', $total_amount, PDO::PARAM_INT);

  $stmt -> execute();

  $dbh -> commit();

  echo '<p>買取明細の登録が完了しました。</p>';
  echo '<p><a href="purchase_list.php">買取情報一覧</a></p>';

}catch(PDOException $e){
  if($dbh && $dbh -> inTransaction()){
    $dbh -> rollBack();
  }
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}
