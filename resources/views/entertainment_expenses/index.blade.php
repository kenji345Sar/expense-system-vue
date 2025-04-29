<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>接待交際費一覧</title>
</head>

<body>
    <h1>接待交際費一覧</h1>
    @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif
    <a href="{{ route('entertainment_expenses.create') }}">新規作成</a>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>利用日</th>
                <th>接待相手</th>
                <th>場所</th>
                <th>金額</th>
                <th>内容</th>
                <th>操作</th>
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
                <td>
                    <a href="{{ route('entertainment_expenses.show', $expense->id) }}">詳細</a>
                    <a href="{{ route('entertainment_expenses.edit', $expense->id) }}">編集</a>
                    <form action="{{ route('entertainment_expenses.destroy', $expense->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                    </form>

                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>