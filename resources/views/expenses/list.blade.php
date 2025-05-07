@extends('layouts.app')

@section('content')
<div class="p-4">
  <h2 class="text-xl font-bold mb-4">申請一覧（ステータス付き）</h2>

  <table class="table-auto w-full border-collapse border border-gray-400">
    <thead>
      <tr class="bg-gray-100">
        @if (auth()->user()->is_admin)
        <th class="border px-2 py-1">申請者</th>
        @endif
        <th class="border px-2 py-1">日付</th>
        <th class="border px-2 py-1">金額</th>
        <th class="border px-2 py-1">内容</th>
        <th class="border px-2 py-1">区分</th>
        <th class="border px-2 py-1">ステータス</th>
        <th class="border px-2 py-1">承認コメント</th>
        <th class="border px-2 py-1">操作</th>

      </tr>
    </thead>
    <tbody>
      @foreach ($expenses as $expense)
      <tr>
        @if (auth()->user()->is_admin)
        <td class="border px-2 py-1">{{ $expense->user->name ?? '-' }}</td>
        @endif

        <td class="border px-2 py-1">{{ $expense->date }}</td>
        <td class="border px-2 py-1">{{ $expense->amount }}</td>
        <td class="border px-2 py-1">{{ $expense->description }}</td>
        <td class="border px-2 py-1">{{ $expense->expense_type }}</td>
        <td class="border px-2 py-1">
          @switch($expense->status)
          @case('draft') 下書き @break
          @case('submitted') 申請中 @break
          @case('approved') 承認済 @break
          @case('returned') 差戻し @break
          @default -
          @endswitch
        </td>
        <td class="border px-2 py-1">
          @if ($expense->status === 'returned' && $expense->approval_comment)
          <span class="text-red-600 text-sm">{{ $expense->approval_comment }}</span>
          @else
          -
          @endif
        </td>
        @if ($expense->status === 'returned' && $expense->user_id === auth()->id())
        <td class="border px-2 py-1">
          <form action="{{ route($expense->expense_type . '_expenses.resubmit', $expense->expense_type_id) }}" method="POST">
            @csrf
            <button type="submit" class="text-blue-500">再申請</button>
          </form>
        </td>
        @else
        <td class="border px-2 py-1">-</td>
        @endif

      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection