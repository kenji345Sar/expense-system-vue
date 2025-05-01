<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>経費メニュー</title>
  <style>
    h1 {
      margin-bottom: 1em;
    }

    ul {
      list-style: none;
      padding-left: 0;
    }

    li {
      margin-bottom: 0.5em;
    }

    a {
      font-size: 1.2em;
    }
  </style>
</head>

<body>
  <h1>経費精算メニュー</h1>
  <ul>
    <li><a href="{{ route('business_trip_expenses.index') }}">出張旅費申請</a></li>
    <li><a href="{{ route('supplies_expenses.index') }}">備品・消耗品費申請</a></li>
    <li><a href="{{ route('entertainment_expenses.index') }}">接待交際費申請</a></li>
    <li><a href="{{ route('transportation_expenses.index') }}">交通費申請</a></li>
  </ul>
</body>

</html>