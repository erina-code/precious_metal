<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

$purchase_id = $_GET['purchase_id'] ?? '';

if(empty($purchase_id)){
  echo '<p>買取受付IDが取得できませんでした。</p>';
  exit;
}

try{
  $dbh = db_open();

  $sql = 'SELECT purchases.purchase_id, customers.customer_name FROM purchases INNER JOIN customers ON purchases.customer_id=customers.customer_id WHERE purchases.purchase_id=:purchase_id';

  $stmt = $dbh -> prepare($sql);

  $stmt -> bindParam(':purchase_id', $purchase_id, PDO::PARAM_INT);

  $stmt ->execute();

  $result = $stmt -> fetch();

  if($result === false){
    echo '<p>指定された買取受付IDのデータが見つかりません。</p>';
    exit;
  } else {

?>

<h1>買取明細登録</h1>

<?php
    echo '<p>買取受付ID：'. str2html($result['purchase_id']). '</p>';
    echo '<p>氏　名：'. str2html($result['customer_name']). '</p>';
  }
?>

<form action="purchase_detail_insert.php" method="post">
  <div id="detail_list">
    <div class="detail_item">
      <p>
        <label>品　名<span class="required">*</span>：</label>
        <input type="text" class="item_name" name="item_name[]" required>
      </p>
      <p>
        <label>金属種類<span class="required">*</span></label>
          <select name="metal_type[]" class="metal_type" required>
            <option value="ゴールド">ゴールド</option>
            <option value="プラチナ">プラチナ</option>
            <option value="シルバー">シルバー</option>
            <option value="コンビ">コンビ</option>
          </select>
      </p>

        <div class="gold_group">
          <label>ゴールド<span class="required">*</span>：</label>
            <select name="gold[]" class="gold">
              <option value="K9">K9</option>
              <option value="K10">K10</option>
              <option value="K14">K14</option>
              <option value="K18">K18</option>
              <option value="K20">K20</option>
              <option value="K22">K22</option>
              <option value="K24">K24</option>
            </select>
        </div>

        <div class="pt_group">
          <label>プラチナ<span class="required">*</span>：</label>
            <select name="pt[]" class="pt">
              <option value="Pt850">Pt850</option>
              <option value="Pt900">Pt900</option>
              <option value="Pt950">Pt950</option>
              <option value="Pt1000">Pt1000</option>
              <option value="Pm">Pm</option>
            </select>
        </div>

        <div class="sv_group">
          <label>シルバー<span class="required">*</span>：</label>
            <select name="sv[]" class="sv">
              <option value="SV925">SV925</option>
              <option value="SV1000">SV1000</option>
            </select>
        </div>

        <div class="combo_group">
          <label>ゴールド：</label>
            <select name="combo_gold[]" class="combo_gold">
              <option value="K9">K9</option>
              <option value="K10">K10</option>
              <option value="K14">K14</option>
              <option value="K18">K18</option>
              <option value="K20">K20</option>
              <option value="K22">K22</option>
              <option value="K24">K24</option>
            </select>

          <label>プラチナ：</label>
            <select name="combo_pt[]" class="combo_pt">
              <option value="Pt850">Pt850</option>
              <option value="Pt900">Pt900</option>
              <option value="Pt950">Pt950</option>
              <option value="Pt1000">Pt1000</option>
              <option value="Pm">Pm</option>
            </select>
        </div>

        <p>
          <label>重　量/g<span class="required">*</span>：</label>
          <input type="number" class="weight" name="weight[]" step="0.1" required>
        </p>

        <p>
          <label>単価/g<span class="required">*</span>：</label>
          <input type="number" class="unit_price" name="unit_price[]" required>
        </p>

        <p>
          <label>買取金額<span class="required">*</span>：</label>
          <input type="number" class="amount" name="amount[]" readonly>
        </p>
    </div>
  </div>

  <p>
    <button type="button" id="add_detail">明細を追加</button>
  </p>

  <p>
    <button type="submit">買取明細登録</button>
    <input type="hidden" name="purchase_id" value="<?= $result['purchase_id']; ?>">
  </p>
</form>

<script>
// ページ内にある全ての明細を取得する
const detailItems = document.querySelectorAll('.detail_item');

// 明細ごとの金属種類を取得する
function setupDetail(detailItem){

  const metalType = detailItem.querySelector('.metal_type');

  // 品位グループを取得する
  const goldGroup = detailItem.querySelector('.gold_group');
  const ptGroup = detailItem.querySelector('.pt_group');
  const svGroup = detailItem.querySelector('.sv_group');
  const comboGroup = detailItem.querySelector('.combo_group');

  function changeMetalType(){
    // 最初に全ての品位グループを非表示にする
    goldGroup.style.display = 'none';
    ptGroup.style.display = 'none';
    svGroup.style.display = 'none';
    comboGroup.style.display = 'none';

    // 金属種類に応じて、該当グループのみを表示させる
    if(metalType.value === 'ゴールド'){
      goldGroup.style.display = 'block';
      } else if(metalType.value === 'プラチナ'){
        ptGroup.style.display = 'block';
      } else if(metalType.value === 'シルバー'){
      svGroup.style.display = 'block';
      } else if(metalType.value === 'コンビ'){
      comboGroup.style.display = 'block';
    }
  }
  metalType.addEventListener('change', changeMetalType);
  changeMetalType();

  // 明細ごとの買取金額を自動計算、重量、単価、合計金額取得
  const weight = detailItem.querySelector('.weight');
  const unitPrice = detailItem.querySelector('.unit_price');
  const amount = detailItem.querySelector('.amount');

  function totalAmount(){
    const numberWeight = Number(weight.value);
    const numberUnitPrice = Number(unitPrice.value);

    amount.value = numberWeight * numberUnitPrice;
  }

  weight.addEventListener('input', totalAmount);
  unitPrice.addEventListener('input', totalAmount);
} // setupDetail()終了

detailItems.forEach(function(detailItem){
  setupDetail(detailItem);
});

const detailList = document.getElementById('detail_list');
const addDetail = document.getElementById('add_detail');

const detailItem = detailList.querySelector('.detail_item');

// 明細追加時の処理をまとめる関数
function addNewDetail(){
  // 明細を複製
  const newDetailItem = detailItem.cloneNode(true);

  const inputs = newDetailItem.querySelectorAll('input');
    inputs.forEach(function(input){
    input.value = '';
  });

    const selects = newDetailItem.querySelectorAll('select');
    selects.forEach(function(input){
    input.value = '';
  });

  // 複製した明細を画面に追加する
  detailList.appendChild(newDetailItem);
  setupDetail(newDetailItem);
}
// クリックする度に追加する
addDetail.addEventListener('click', addNewDetail);

</script>

<?php
}catch(PDOException $e){
  echo '<p>エラー！：'. str2html($e -> getMessage()). '</p>';
}