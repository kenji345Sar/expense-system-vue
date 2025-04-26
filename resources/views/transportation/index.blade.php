<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>交通費申請一覧</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 0.5em;
            text-align: left;
        }
    </style>
</head>

<body>
    @if (session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif

    <h1>交通費申請一覧</h1>

    <table>
        <thead>
            <tr>
                <th>申請日</th>
                <th>出発地</th>
                <th>到着地</th>
                <th>経路</th>
                <th>金額</th>
                <th>備考</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->use_date }}</td>
                    <td>{{ $item->departure }}</td>
                    <td>{{ $item->arrival }}</td>
                    <td>{{ $item->route ?? '-' }}</td>
                    <td>{{ number_format($item->amount) }} 円</td>
                    <td>{{ $item->remarks ?? '-' }}</td>
                    <td>
                        <a href="{{ route('transportation.show', $item->id) }}">詳細</a>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6">データがありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p><a href="{{ url('/transportation/create') }}">← 新規申請へ</a></p>
</body>

</html>
