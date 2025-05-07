{{-- resources/views/supplies_expenses/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8" x-data="{ rows: [{}] }">
  <h2 class="text-2xl font-bold mb-6">備品・消耗品費申請フォーム</h2>

  @php
  $fieldName = 'username';
  @endphp


  <div x-data="{ userName: 'あああ' }">
    <input :name="userName">
  </div>

  @php
  $defaultName = '山田太郎';
  @endphp

  <div x-data="{ userName: '{{ $defaultName }}' }">
    <label>名前:</label>
    <input
      type="text"
      name="user_name"
      x-model="userName"
      class="border p-2">

    <p class="mt-2 text-sm text-gray-600">
      入力中の名前: <span x-text="userName"></span>
    </p>
  </div>

  <form action="{{ route('supplies_expenses.store') }}" method="POST" class="space-y-4" novalidate>
    @csrf

    <div x-data="{
        rows: [
            { use_date: '', departure: '', arrival: '', amount: '' }
        ],
        addRow() {
            this.rows.push({ use_date: '', departure: '', arrival: '', amount: '' });
        }
    }">

      <template x-for="(row, index) in rows" :key="index">
        <div class="border p-4 mb-4 rounded bg-gray-50">
          <h4 class="font-bold mb-2">交通費 <span x-text="index + 1"></span></h4>

          <input type="date"
            :name="`transportation_expenses[${index}][use_date]`"
            x-model="row.use_date"
            class="border p-2 w-full mb-2"
            placeholder="利用日">

          <input
            type="text"
            x-bind:name="`transportation_expenses[${index}][departure]`"
            x-model="row.departure"
            class="..."
            placeholder="出発地" />

          <input type="text"
            :name="`transportation_expenses[${index}][arrival]`"
            x-model="row.arrival"
            class="border p-2 w-full mb-2"
            placeholder="到着地">

          <input type="number"
            :name="`transportation_expenses[${index}][amount]`"
            x-model="row.amount"
            class="border p-2 w-full mb-2"
            placeholder="金額">
        </div>
      </template>

      <button type="button" @click="addRow" class="bg-blue-500 text-white px-4 py-2 rounded">
        ＋ 行を追加
      </button>

      <div class="mt-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
          登録
        </button>
      </div>
    </div>
  </form>


</div>
@endsection