<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>接待交際費一覧</title>
</head>
<body>
    <h1>接待交際費一覧</h1>

    <a href="{{ route('entertainment_expenses.create') }}">新規作成</a>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>利用日</th>
                <th>接待相手</th>
                <th>場所</th>
                <th>金額</th>
                <th>内容</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
                <tr>
                    <td>{{ $expense->date }}</td>
                    <td>{{ $expense->client_name }}</td>
                    <td>{{ $expense->place }}</td>
                    <td>{{ $expense->amount }}</td>
                    <td>{{ $expense->content }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
