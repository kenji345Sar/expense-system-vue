@extends('layouts.app')

@section('title', '交通費申請一覧')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">交通費申請一覧</h1>

    {{-- フラッシュメッセージ --}}
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

    @if (auth()->user()->is_admin)
    <p class="text-sm text-gray-500 mb-4">※ 管理者モード：全ユーザのデータを表示中</p>
    @endif

    {{-- テーブル表示 --}}
    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">申請者</th>
                <th class="p-2 border">利用日</th>
                <th class="p-2 border">区間</th>
                <th class="p-2 border">経路</th>
                <th class="p-2 border">金額</th>
                <th class="p-2 border">操作</th> {{-- ← 操作列を追加 --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
            @php
            $details = $expense->transportationExpenses;
            @endphp

            <tr class="border-t">
                <td class="p-2 border">{{ $expense->id }}</td>
                <td class="p-2 border">{{ $expense->user->name }}</td>

                @if ($details->count() === 1)
                @php $detail = $details->first(); @endphp
                <td class="p-2 border">{{ $detail->use_date }}</td>
                <td class="p-2 border">{{ $detail->departure }} → {{ $detail->arrival }}</td>
                <td class="p-2 border">{{ $detail->route }}</td>
                <td class="p-2 border text-right">{{ number_format($detail->amount) }} 円</td>
                @else
                <td class="p-2 border">明細 {{ $details->count() }} 件</td>
                <td class="p-2 border" colspan="2">詳細は別途</td>
                <td class="p-2 border text-right">
                    {{ number_format($details->sum('amount')) }} 円
                </td>
                @endif

                {{-- 操作列 --}}
                <td class="p-2 border space-x-2 text-center">
                    <a href="{{ route('transportation_expenses.edit', $expense->id) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm">
                        編集
                    </a>
                    <a href="{{ route('transportation_expenses.show', $expense->id) }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white px-2 py-1 rounded text-sm">
                        詳細
                    </a>
                    <form action="{{ route('transportation_expenses.submit', $expense->id) }}" method="POST"
                        class="inline-block"
                        onsubmit="return confirm('申請しますか？');">
                        @csrf
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white px-2 py-1 rounded text-sm">
                            申請
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <div class="mt-6 space-y-2">
        <a href="{{ route('transportation_expenses.create') }}" class="text-blue-500 hover:underline">← 新規申請へ</a><br>
        <a href="{{ route('expenses.index') }}" class="text-blue-500 hover:underline">← 経費メニューへ戻る</a>
    </div>
</div>
@endsection