@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">
  <h2 class="text-2xl font-bold mb-6">出張旅費 新規フォーム</h2>

  @if ($errors->any())
  <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
    <strong>入力内容にエラーがあります:</strong>
    <ul class="list-disc pl-5 mt-2">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form method="POST" action="{{ route('business_trip.store') }}" id="tripForm">
    @csrf

    <!-- メモ -->
    <div class="mb-4">
      <label class="block font-bold mb-1">申請メモ（任意）</label>
      <textarea name="description" class="border w-full p-2 rounded">{{ old('description') }}</textarea>
    </div>

    <!-- 明細行コンテナ -->
    <div id="details-container">
      @php $count = old('row_count', 1); @endphp
      @for ($i = 0; $i < $count; $i++)
        <div class="detail-row border p-4 mb-4 rounded bg-white shadow-sm">
        <h4 class="font-bold mb-2">出張費 {{ $i + 1 }}</h4>

        <input type="date" name="business_trip_expenses[{{ $i }}][business_trip_date]" value="{{ old("business_trip_expenses.$i.business_trip_date") }}" class="border p-2 w-full mb-2" placeholder="利用日">
        <input type="text" name="business_trip_expenses[{{ $i }}][departure]" value="{{ old("business_trip_expenses.$i.departure") }}" class="border p-2 w-full mb-2" placeholder="出発地">
        <input type="text" name="business_trip_expenses[{{ $i }}][destination]" value="{{ old("business_trip_expenses.$i.destination") }}" class="border p-2 w-full mb-2" placeholder="到着地">
        <input type="text" name="business_trip_expenses[{{ $i }}][purpose]" value="{{ old("business_trip_expenses.$i.purpose") }}" class="border p-2 w-full mb-2" placeholder="目的">
        <input type="number" name="business_trip_expenses[{{ $i }}][amount]" value="{{ old("business_trip_expenses.$i.amount") }}" class="border p-2 w-full mb-2" placeholder="金額">
        <input type="text" name="business_trip_expenses[{{ $i }}][remarks]" value="{{ old("business_trip_expenses.$i.remarks") }}" class="border p-2 w-full mb-2" placeholder="備考（任意）">
    </div>
    @endfor
</div>

<!-- hiddenで件数送信 -->
<input type="hidden" name="row_count" id="row_count" value="{{ $count }}">

<!-- 行追加・削除ボタン -->
<div class="mb-4 flex space-x-4">
  <button type="button" onclick="addDetailRow()" class="bg-blue-500 text-white px-4 py-2 rounded">＋ 行を追加</button>
  <button type="button" onclick="removeDetailRow()" class="bg-red-500 text-white px-4 py-2 rounded">－ 行を削除</button>
</div>

<!-- 登録・戻る -->
<div class="flex space-x-4">
  <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded">登録</button>
  <a href="{{ route('business_trip.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded">戻る</a>
</div>
</form>

<!-- テンプレート行 -->
<template id="detail-template">
  <div class="detail-row border p-4 mb-4 rounded bg-white shadow-sm">
    <h4 class="font-bold mb-2">出張費 <span class="row-number"></span></h4>

    <input type="date" class="use-date border p-2 w-full mb-2" placeholder="利用日">
    <input type="text" class="departure border p-2 w-full mb-2" placeholder="出発地">
    <input type="text" class="arrival border p-2 w-full mb-2" placeholder="到着地">
    <input type="text" class="route border p-2 w-full mb-2" placeholder="目的">
    <input type="number" class="amount border p-2 w-full mb-2" placeholder="金額">
    <input type="text" class="remarks border p-2 w-full mb-2" placeholder="備考（任意）">
  </div>
</template>
</div>

<script>
  function addDetailRow() {
    const container = document.getElementById('details-container');
    const template = document.getElementById('detail-template');
    const clone = template.content.cloneNode(true);

    const currentCount = container.querySelectorAll('.detail-row').length;
    const newIndex = currentCount;

    // ラベル更新
    clone.querySelector('.row-number').textContent = newIndex + 1;

    // input に name 属性を追加
    clone.querySelector('.use-date').setAttribute('name', `business_trip_expenses[${newIndex}][business_trip_date]`);
    clone.querySelector('.departure').setAttribute('name', `business_trip_expenses[${newIndex}][departure]`);
    clone.querySelector('.arrival').setAttribute('name', `business_trip_expenses[${newIndex}][destination]`);
    clone.querySelector('.route').setAttribute('name', `business_trip_expenses[${newIndex}][purpose]`);
    clone.querySelector('.amount').setAttribute('name', `business_trip_expenses[${newIndex}][amount]`);
    clone.querySelector('.remarks').setAttribute('name', `business_trip_expenses[${newIndex}][remarks]`);

    container.appendChild(clone);

    // row_count を更新
    document.getElementById('row_count').value = newIndex + 1;
  }

  function removeDetailRow() {
    const container = document.getElementById('details-container');
    const rows = container.querySelectorAll('.detail-row');
    if (rows.length > 1) {
      rows[rows.length - 1].remove();
      document.getElementById('row_count').value = rows.length - 1;
    } else {
      alert('これ以上削除できません。');
    }
  }
</script>
@endsection