@extends('layouts.app')

@section('title', '交通費申請一覧')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">交通費申請一覧</h1>

    @foreach (['success', 'error', 'warning', 'info'] as $msg)
    @if (session($msg))
    <p class="mb-4 p-2 rounded bg-{{ $msg == 'success' ? 'green' : ($msg == 'error' ? 'red' : 'yellow') }}-100 text-{{ $msg == 'success' ? 'green' : ($msg == 'error' ? 'red' : 'yellow') }}-800">
        {{ session($msg) }}
    </p>
    @endif
    @endforeach

    <div class="mb-4">
        <a href="{{ route('transportation_expenses.create') }}" class="text-blue-600 hover:underline">＋ 新規申請</a>
    </div>

    <table class="min-w-full bg-white border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 text-left">利用日</th>
                <th class="border px-4 py-2 text-left">出発地</th>
                <th class="border px-4 py-2 text-left">到着地</th>
                <th class="border px-4 py-2 text-left">経路</th>
                <th class="border px-4 py-2 text-left">金額</th>
                <th class="border px-4 py-2 text-left">備考</th>
                <th class="border px-4 py-2 text-left">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
            <tr>
                <td class="border px-4 py-2">{{ $item->use_date }}</td>
                <td class="border px-4 py-2">{{ $item->departure }}</td>
                <td class="border px-4 py-2">{{ $item->arrival }}</td>
                <td class="border px-4 py-2">{{ $item->route ?? '-' }}</td>
                <td class="border px-4 py-2">{{ number_format($item->amount) }} 円</td>
                <td class="border px-4 py-2">{{ $item->remarks ?? '-' }}</td>
                <td class="border px-4 py-2 space-x-2">
                    <a href="{{ route('transportation_expenses.show', $item->id) }}" class="text-blue-500 hover:underline">詳細</a>
                    <a href="{{ route('transportation_expenses.edit', $item->id) }}" class="text-green-500 hover:underline">編集</a>
                    <form action="{{ route('transportation_expenses.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('本当に削除しますか？')">削除</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="border px-4 py-2 text-center text-gray-500">データがありません。</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-6 space-y-2">
        <a href="{{ route('transportation_expenses.create') }}" class="text-blue-500 hover:underline">← 新規申請へ</a><br>
        <a href="{{ route('expenses.index') }}" class="text-blue-500 hover:underline">← 経費メニューへ戻る</a>
    </div>
</div>
@endsection