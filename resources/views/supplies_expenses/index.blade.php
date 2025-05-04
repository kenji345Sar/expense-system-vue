@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">備品・消耗品費 一覧</h1>
    <a href="{{ route('supplies_expenses.create') }}"
      class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded shadow hover:bg-blue-500 hover:shadow-md transition">
      ＋新規作成
    </a>
  </div>

  @if (auth()->user()->is_admin)
  <p class="text-sm text-gray-500 mb-4">※ 管理者モード：全ユーザのデータを表示中</p>
  @endif

  <x-flash-message />

  <div class="overflow-x-auto bg-white shadow rounded-lg">
    <table class="min-w-full table-auto border-collapse border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          @if (auth()->user()->is_admin)
          <th class="px-4 py-2 border">ユーザ名</th>
          @endif
          <th class="px-4 py-2 border">日付</th>
          <th class="px-4 py-2 border">品名</th>
          <th class="px-4 py-2 border">数量</th>
          <th class="px-4 py-2 border">単価</th>
          <th class="px-4 py-2 border">合計金額</th>
          <th class="px-4 py-2 border">備考</th>
          <th class="px-4 py-2 border">操作</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($suppliesExpenses as $expense)
        <tr>
          @if (auth()->user()->is_admin)
          <td class="px-4 py-2 border">{{ $expense->user->name ?? '-' }}</td>
          @endif
          <td class="px-4 py-2 border">{{ $expense->date ?? '-' }}</td>
          <td class="px-4 py-2 border">{{ $expense->item_name }}</td>
          <td class="px-4 py-2 border">{{ $expense->quantity }}</td>
          <td class="px-4 py-2 border">{{ number_format($expense->unit_price) }}</td>
          <td class="px-4 py-2 border">{{ number_format($expense->total_price) }}</td>
          <td class="px-4 py-2 border">{{ $expense->note }}</td>
          <td class="px-4 py-2 border text-center whitespace-nowrap">
            <a href="{{ route('supplies_expenses.edit', $expense) }}"
              class="text-blue-600 hover:underline font-medium">編集</a>
            |
            <form action="{{ route('supplies_expenses.destroy', $expense) }}" method="POST"
              class="inline-block"
              onsubmit="return confirm('本当に削除しますか？')">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline font-medium">削除</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="px-4 py-6 text-center text-gray-500">データはありません</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection