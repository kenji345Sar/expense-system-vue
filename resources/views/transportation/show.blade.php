<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>申請詳細</title>
</head>

<body>
    <h1>交通費申請の詳細</h1>

    <ul>
        <li><strong>申請日：</strong> {{ $item->use_date }}</li>
        <li><strong>出発地：</strong> {{ $item->departure }}</li>
        <li><strong>到着地：</strong> {{ $item->arrival }}</li>
        <li><strong>経路：</strong> {{ $item->route ?? '（なし）' }}</li>
        <li><strong>金額：</strong> {{ number_format($item->amount) }} 円</li>
        <li><strong>備考：</strong> {{ $item->remarks ?? '（なし）' }}</li>
        <li><strong>登録日時：</strong> {{ $item->created_at }}</li>
    </ul>

    <p>
        <a href="{{ route('transportation_expenses.edit', $item->id) }}">編集</a>
    </p>

    <form method="POST" action="{{ route('transportation_expenses.destroy', $item->id) }}"
        onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <button type="submit">削除</button>
    </form>


    <p><a href="{{ url('/transportation_expenses') }}">← 一覧に戻る</a></p>
</body>

</html>