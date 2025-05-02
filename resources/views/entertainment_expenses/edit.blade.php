<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>接待交際費 編集</title>
</head>

<body>
  <h1>接待交際費 編集</h1>
  @if ($errors->any())
  <div style="color: red;">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('entertainment_expenses.update', $expense->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
      <label>利用日:</label>
      <input type="date" name="entertainment_date" value="{{ old('entertainment_date', $expense->entertainment_date) }}">
    </div>

    <div>
      <label>接待相手:</label>
      <input type="text" name="client_name" value="{{ old('client_name', $expense->client_name) }}">
    </div>

    <div>
      <label>場所:</label>
      <input type="text" name="place" value="{{ old('place', $expense->place) }}">
    </div>

    <div>
      <label>金額:</label>
      <input type="number" name="amount" value="{{ old('amount', $expense->amount) }}">
    </div>

    <div>
      <label>内容（任意）:</label>
      <textarea name="content">{{ old('content', $expense->content) }}</textarea>
    </div>

    <button type="submit">更新する</button>
  </form>

  <a href="{{ route('entertainment_expenses.index') }}">← 一覧に戻る</a>
</body>

</html>