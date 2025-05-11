@extends('layouts.app')

@section('title', '出張旅費一覧')

@section('content')
<div class="max-w-6xl mx-auto py-8">
  <h1 class="text-2xl font-bold mb-6">出張旅費一覧</h1>

  <x-alert-message />

  <div class="mb-4">
    <x-action-button :href="route('business_trip.create')" color="blue" class="text-xl text-black-800 font-semibold">
      ＋ 新規申請
    </x-action-button>
  </div>

  @if (auth()->user()->is_admin)
  <p class="text-sm text-gray-500 mb-4">※ 管理者モード：全ユーザのデータを表示中</p>
  @endif

  <table class="min-w-full bg-white border border-gray-300">
    <thead class="bg-gray-100">
      <tr>
        @if (auth()->user()->is_admin)
        <x-table.th>id</x-table.th>
        <x-table.th>ユーザ名</x-table.th>
        @endif
        <x-table.th>出張日</x-table.th>
        <x-table.th>出発地</x-table.th>
        <x-table.th>到着地</x-table.th>
        <x-table.th>交通手段</x-table.th>
        <x-table.th>目的</x-table.th>
        <x-table.th>合計金額</x-table.th>
        <x-table.th>備考</x-table.th>
        <x-table.th>ステータス</x-table.th>
        <x-table.th>操作</x-table.th>
      </tr>
    </thead>
    <tbody>
      @forelse ($business_trip_expenses as $expense)
      @php
      $details = $expense->businessTripExpenses;
      @endphp

      <tr>
        @if (auth()->user()->is_admin)
        <x-table.td>{{ $expense->id ?? '-' }}</x-table.td>
        <x-table.td>{{ $expense->user->name ?? '-' }}</x-table.td>
        @endif
        @if ($details->count() === 1)
        @php $detail = $details->first(); @endphp
        <x-table.td>{{ $detail->business_trip_date }}</x-table.td>
        <x-table.td>{{ $detail->departure }}</x-table.td>
        <x-table.td>{{ $detail->destination }}</x-table.td>
        <x-table.td>{{ $detail->transportation }}</x-table.td>
        <x-table.td>{{ $detail->purpose }}</x-table.td>
        <x-table.td>{{ $detail->remarks ?? '-' }}</x-table.td>
        <x-table.td>{{ number_format($expense->amount) }} 円</x-table.td>
        @else
        <td class="p-2 border">明細 {{ $details->count() }} 件</td>
        <td class="p-2 border" colspan="5">詳細は別途</td>
        <x-table.td>{{ number_format($details->sum('amount')) }} 円</x-table.td>
        @endif


        <x-table.td>ステータス</x-table.td>
        <x-table.td>
          <div class="flex flex-wrap gap-x-4 gap-2">
            <x-action-button type="form"
              method="GET"
              :href="route('business_trip.edit', $expense->id)"
              color="green"
              formMargin="mr-[6px]"
              class="text-sm">
              編集
            </x-action-button>
            <div style="width: 6px;"></div>
            <x-action-button type="form" :href="route('business_trip.submit', $expense->id)" method="POST" color="blue" class="text-sm">
              申請
            </x-action-button>

            @if (auth()->user()->is_approver && $expense->status === 'submitted')
            <x-action-button type="form" :href="route('business_trip.approve', $expense->id)" method="POST" color="purple">
              承認
            </x-action-button>
            @endif
          </div>

        </x-table.td>
      </tr>
      @empty
      <tr>
        <td colspan="10" class="border px-4 py-2 text-center text-gray-500">データがありません。</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-6 space-y-2">
    <x-action-button :href="route('expenses.menu')" color="blue" class="text-blue-600 font-semibold">
      ← 経費メニューへ戻る
    </x-action-button>
  </div>
</div>
@endsection