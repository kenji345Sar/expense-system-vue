@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">接待交際費一覧</h2>

    @foreach (['success', 'error', 'warning', 'info'] as $msg)
    @if (session($msg))
    <p class="mb-4 p-2 rounded bg-{{ $msg == 'success' ? 'green' : ($msg == 'error' ? 'red' : 'yellow') }}-100 text-{{ $msg == 'success' ? 'green' : ($msg == 'error' ? 'red' : 'yellow') }}-800">
        {{ session($msg) }}
    </p>
    @endif
    @endforeach

    <div class="mb-4">
        <a href="{{ route('entertainment_expenses.create') }}" class="text-blue-600 hover:underline">＋ 新規申請</a>
    </div>

    <table class="min-w-full bg-white border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 text-left">利用日</th>
                <th class="border px-4 py-2 text-left">接待相手</th>
                <th class="border px-4 py-2 text-left">場所</th>
                <th class="border px-4 py-2 text-left">金額</th>
                <th class="border px-4 py-2 text-left">内容</th>
                <th class="border px-4 py-2 text-left">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($entertainment_expenses as $expense)
            <tr>
                <td class="border px-4 py-2">{{ $expense->entertainment_date }}</td>
                <td class="border px-4 py-2">{{ $expense->client_name }}</td>
                <td class="border px-4 py-2">{{ $expense->place }}</td>
                <td class="border px-4 py-2">{{ $expense->amount }}</td>
                <td class="border px-4 py-2">{{ $expense->description }}</td>
                <td class="border px-4 py-2 space-x-2">
                    <a href="{{ route('entertainment_expenses.show', $expense->id) }}" class="text-blue-500 hover:underline">詳細</a>
                    <a href="{{ route('entertainment_expenses.edit', $expense->id) }}" class="text-green-500 hover:underline">編集</a>
                    <form action="{{ route('entertainment_expenses.destroy', $expense->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('本当に削除しますか？')">削除</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="border px-4 py-2 text-center text-gray-500">データがありません。</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection