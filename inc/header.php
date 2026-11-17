<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>貴金属買取アプリ</title>
  <style>
    body {
      font-family: sans-serif;
      margin: 30px;
      color: #333;
    }

    h1 {
      font-size: 28px;
      margin-bottom: 25px;
    }

    nav {
      margin-bottom: 25px;
    }

    nav a {
      color: #0000EE;
      display: inline-block;
      margin-right: 20px;
    }

    input, button {
      padding: 8px;
      margin: 5px;
    }

    nav p {
      font-weight: bold;
      margin-bottom: 5px;
    }

    .required {
      color: red;
    }

    .detail_item {
      border: 1px solid #ccc;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 8px;
    }

    .item_name {
      width: 350px;
      box-sizing: border-box;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      padding: 5px;
    }

    th {
      text-align: center;
    }

    .table_scroll {
      width: 100%;
      overflow: auto;
    }

    .customer_table {
      width: 1100px;
      table-layout: auto;
    }

    .customer_table th:nth-child(1),
    .customer_table td:nth-child(1),
    .customer_table th:nth-child(3),
    .customer_table td:nth-child(3) {
      white-space: nowrap;
      min-width: 80px;
    }

    .customer_table th:nth-child(2),
    .customer_table td:nth-child(2),
    .customer_table th:nth-child(6),
    .customer_table td:nth-child(6) {
      white-space: nowrap;
      min-width: 100px;
    }

    .customer_table th:nth-child(5),
    .customer_table td:nth-child(5),
    .customer_table th:nth-child(7),
    .customer_table td:nth-child(7) {
      white-space: normal;
    }

    .right {
      text-align: right;
    }

    .purchase_search_table th,
    .purchase_search_table td {
      white-space: nowrap;
      padding: 8px 12px;
    }

    .purchase_search_table {
      display: inline-table;
      width: auto;
      max-width: 100%;
      table-layout: auto;
    }

  </style>
</head>
<body>
  <nav>
    <p>メニュー</p>
    <a href="customer_list.php">顧客情報一覧</a>
    <a href="purchase_list.php">買取情報一覧</a>
  </nav>
