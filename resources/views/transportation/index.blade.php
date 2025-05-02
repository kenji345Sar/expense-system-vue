@extends('layouts.app')

@section('title', '交通費申請一覧')

@section('content')
<h1>交通費申請一覧</h1>
@foreach (['success', 'error', 'warning', 'info'] as $msg)
@if (session($msg))
<p class="{{ $msg }}">{{ session($msg) }}</p>
@endif
@endforeach


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
                <a href="{{ route('transportation_expenses.show', $item->id) }}">詳細</a>
                <!-- 編集リンク -->
                <a href="{{ route('transportation_expenses.edit', $item->id) }}">編集</a>

                <!-- 削除フォーム -->
                <form action="{{ route('transportation_expenses.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                </form>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="6">データがありません。</td>
        </tr>
        @endforelse
    </tbody>
</table>

<p>
    <<a href="{{ route('transportation_expenses.create') }}">← 新規申請へ</a>
</p>
<p>
    <a href="{{ route('expenses.index') }}">← 経費メニューへ戻る</a>
</p>

@endsection