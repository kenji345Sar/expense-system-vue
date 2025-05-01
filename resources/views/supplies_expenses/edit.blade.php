<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>備品・消耗品費 編集フォーム</title>
</head>

<body>
  <h1>備品・消耗品費 編集</h1>

  @if (session('success'))
  <p style="color: green;">{{ session('success') }}</p>
  @endif

  <form action="{{ route('supplies_expenses.update', $supplies_expense->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
      <label>日付:</label>
      <input type="date" name="date" value="{{ old('date', $supplies_expense->date) }}">
    </div>

    <div>
      <label>品名:</label>
      <input type="text" name="item_name" value="{{ old('item_name', $supplies_expense->item_name) }}">
    </div>

    <div>
      <label>数量:</label>
      <input type="number" name="quantity" value="{{ old('quantity', $supplies_expense->quantity) }}">
    </div>

    <div>
      <label>単価:</label>
      <input type="number" name="unit_price" value="{{ old('unit_price', $supplies_expense->unit_price) }}">
    </div>

    <div>
      <label>合計金額:</label>
      <input type="number" name="total_price" value="{{ old('total_price', $supplies_expense->total_price) }}">
    </div>

    <div>
      <label>備考:</label>
      <textarea name="remarks">{{ old('remarks', $supplies_expense->remarks) }}</textarea>
    </div>

    <button type="submit">更新する</button>
  </form>

  <p><a href="{{ route('supplies_expenses.index') }}">← 一覧に戻る</a></p>
</body>

</html>