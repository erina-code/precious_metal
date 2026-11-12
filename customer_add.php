<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';
?>


  <h1>顧客登録</h1>
  <form action="customer_insert.php" method="post">
    <p>
      <label for="customer_name">顧客名<span class="required">*</span>：</label>
      <input type="text" id="customer_name" name="customer_name" required>
    </p>
    <p>
      <label for="tel">電話番号：</label>
      <input type="text" id="tel" name="tel">
    </p>
    <p>
      <label for="address">住　所：</label>
      <input type="text" id="address" name="address">
    </p>
    <p>
      <label for="birth_date">生年月日：</label>
      <input type="date" id="birth_date" name="birth_date">
    </p>
    <p>
      <label for="remarks">備　考：</label>
      <textarea name="remarks" id="remarks" ></textarea>
    </p>
    <p>
      <input type="submit" value="登録">
    </p>
  </form>
</body>
</html>
