<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>接待交際費 詳細</title>
</head>
<body>
    <h1>接待交際費 詳細</h1>

    <p><strong>利用日:</strong> {{ $expense->date }}</p>
    <p><strong>接待相手:</strong> {{ $expense->client_name }}</p>
    <p><strong>場所:</strong> {{ $expense->place }}</p>
    <p><strong>金額:</strong> {{ number_format($expense->amount) }} 円</p>
    <p><strong>内容:</strong> {{ $expense->content }}</p>

    <a href="{{ route('entertainment_expenses.index') }}">← 一覧に戻る</a>
</body>
</html>
