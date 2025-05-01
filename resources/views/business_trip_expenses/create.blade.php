<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>出張旅費申請フォーム</title>
</head>

<body>
  <h1>出張旅費申請フォーム</h1>

  @if (session('success'))
  <p style="color: green;">{{ session('success') }}</p>
  @endif

  @if ($errors->any())
  <div style="color:red;">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('business_trip_expenses.store') }}" method="POST">
    @csrf
    <div>
      <label>日付:</label>
      <input type="date" name="date" value="{{ old('date') }}">
    </div>
    <div>
      <label>出発地:</label>
      <input type="text" name="departure" value="{{ old('departure') }}">
    </div>
    <div>
      <label>到着地:</label>
      <input type="text" name="destination" value="{{ old('destination') }}">
    </div>
    <div>
      <label>目的:</label>
      <input type="text" name="purpose" value="{{ old('purpose') }}">
    </div>
    <div>
      <label>交通手段:</label>
      <input type="text" name="transportation" value="{{ old('transportation') }}">
    </div>
    <label>宿泊有無:</label>
    <input type="checkbox" name="accommodation" value="1">
    <div>
      <label>金額:</label>
      <input type="number" name="amount" value="{{ old('amount') }}">
    </div>
    <div>
      <label>備考:</label>
      <textarea name="remarks">{{ old('remarks') }}</textarea>
    </div>
    <button type="submit">申請</button>
  </form>
</body>

</html>