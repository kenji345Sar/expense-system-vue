<!-- resources/views/transportation/create.blade.php -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>交通費申請</title>
</head>

<body>
    <h1>交通費申請フォーム</h1>
    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('transportation_expenses.store') }}">
        @csrf
        <label>利用日: <<input type="date" name="use_date" value="{{ old('use_date') }}"></label><br><br>
        <label>出発地: <input type="text" name="departure" value="{{ old('departure') }}"></label><br><br>
        <label>到着地: <input type="text" name="arrival" value="{{ old('arrival') }}"></label><br><br>
        <label>経路（任意）: <input type="text" name="route"></label><br><br>
        <label>金額: <input type="number" name="amount" step="0.01"></label><br><br>
        <label>備考（任意）:
            <textarea name="remarks"></textarea>
        </label><br><br>
        <button type="submit">申請</button>
    </form>
    @if (session('message'))
    <p style="color: green;">{{ session('message') }}</p>
    @endif
</body>

</html>