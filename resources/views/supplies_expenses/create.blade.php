<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>備品・消耗品費申請フォーム</title>
</head>

<body>
  <h1>備品・消耗品費申請フォーム</h1>

  @if (session('success'))
  <p style="color: green;">{{ session('success') }}</p>
  @endif

  <form action="{{ route('supplies_expenses.store') }}" method="POST">
    @csrf
    <div>
      <label>日付:</label>
      <input type="date" name="date" value="{{ old('date') }}">
    </div>
    <div>
      <label>品名:</label>
      <input type="text" name="item_name" value="{{ old('item_name') }}">
    </div>
    <div>
      <label>数量:</label>
      <input type="number" name="quantity" value="{{ old('quantity') }}">
    </div>
    <div>
      <label>単価:</label>
      <input type="number" name="unit_price" value="{{ old('unit_price') }}">
    </div>
    <div>
      <label>合計金額:</label>
      <input type="number" name="total_price" value="{{ old('total_price') }}">
    </div>
    <div>
      <label>備考:</label>
      <textarea name="remarks">{{ old('remarks') }}</textarea>
    </div>
    <button type="submit">申請</button>
  </form>
</body>

</html>