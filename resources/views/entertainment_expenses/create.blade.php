<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>接待交際費申請フォーム</title>
</head>

<body>
    <h1>接待交際費申請フォーム</h1>

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('entertainment_expenses.store') }}" method="POST">
        @csrf

        <div>
            <label>利用日:</label>
            <input type="date" name="entertainment_date" value="{{ old('entertainment_date') }}">
        </div>

        <div>
            <label>接待相手:</label>
            <input type="text" name="client_name" value="{{ old('client_name') }}">
        </div>

        <div>
            <label>場所:</label>
            <input type="text" name="place" value="{{ old('place') }}">
        </div>

        <div>
            <label>金額:</label>
            <input type="number" name="amount" value="{{ old('amount') }}">
        </div>

        <div>
            <label>内容（任意）:</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <button type="submit">申請</button>
    </form>
</body>

</html>