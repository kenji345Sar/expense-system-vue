@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">
  <h2 class="text-2xl font-bold mb-6">備品・消耗品費 新規フォーム</h2>

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

  <form method="POST" action="{{ route('supplies.store') }}">
    @csrf

    <div id="details-container">
      @php $count = old('row_count', 1); @endphp
      @for ($i = 0; $i < $count; $i++)
        <div class="detail-row border p-4 mb-4 rounded bg-white shadow-sm">
        <h4 class="font-bold mb-2">明細 {{ $i + 1 }}</h4>

        <input type="date" name="supplies[{{ $i }}][supply_date]" value="{{ old("supplies.$i.supply_date") }}" class="border p-2 w-full mb-2" placeholder="購入日">
        <input type="text" name="supplies[{{ $i }}][item_name]" value="{{ old("supplies.$i.item_name") }}" class="border p-2 w-full mb-2" placeholder="品名">
        <input type="number" name="supplies[{{ $i }}][quantity]" value="{{ old("supplies.$i.quantity") }}" class="quantity border p-2 w-full mb-2" placeholder="数量" min="1">
        <input type="number" name="supplies[{{ $i }}][unit_price]" value="{{ old("supplies.$i.unit_price") }}" class="unit-price border p-2 w-full mb-2" placeholder="単価" min="0">
        <input type="number" name="supplies[{{ $i }}][total_price]" value="{{ old("supplies.$i.total_price") }}" class="total-price border p-2 w-full mb-2" placeholder="合計金額" readonly>
        <input type="text" name="supplies[{{ $i }}][remarks]" value="{{ old("supplies.$i.remarks") }}" class="border p-2 w-full mb-2" placeholder="備考（任意）">
    </div>
    @endfor
</div>

<input type="hidden" name="row_count" id="row_count" value="{{ $count }}">

<div class="mb-4 flex space-x-4">
  <button type="button" onclick="addDetailRow()" class="bg-blue-500 text-white px-4 py-2 rounded">＋ 行を追加</button>
  <button type="button" onclick="removeDetailRow()" class="bg-red-500 text-white px-4 py-2 rounded">－ 行を削除</button>
</div>

<div class="flex space-x-4">
  <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded">登録</button>
  <a href="{{ route('supplies.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded">戻る</a>
</div>
</form>

<template id="detail-template">
  <div class="detail-row border p-4 mb-4 rounded bg-white shadow-sm">
    <h4 class="font-bold mb-2">明細 <span class="row-number"></span></h4>

    <input type="date" class="supply-date border p-2 w-full mb-2" placeholder="購入日">
    <input type="text" class="item-name border p-2 w-full mb-2" placeholder="品名">
    <input type="number" class="quantity border p-2 w-full mb-2" placeholder="数量" min="1">
    <input type="number" class="unit-price border p-2 w-full mb-2" placeholder="単価" min="0">
    <input type="number" class="total-price border p-2 w-full mb-2" placeholder="合計金額" readonly>
    <input type="text" class="remarks border p-2 w-full mb-2" placeholder="備考（任意）">
  </div>
</template>
</div>

<script>
  function calculateTotalPrice(quantityInput, unitPriceInput, totalPriceInput) {
    const quantity = parseInt(quantityInput.value) || 0;
    const unitPrice = parseInt(unitPriceInput.value) || 0;
    totalPriceInput.value = quantity * unitPrice;
  }

  function bindCalculationEvents(row) {
    const quantityInput = row.querySelector('.quantity');
    const unitPriceInput = row.querySelector('.unit-price');
    const totalPriceInput = row.querySelector('.total-price');

    quantityInput.addEventListener('input', () =>
      calculateTotalPrice(quantityInput, unitPriceInput, totalPriceInput)
    );
    unitPriceInput.addEventListener('input', () =>
      calculateTotalPrice(quantityInput, unitPriceInput, totalPriceInput)
    );
  }

  // 既存の行（明細1など）にもイベントをバインド
  document.querySelectorAll('.detail-row').forEach(bindCalculationEvents);



  function addDetailRow() {
    const container = document.getElementById('details-container');
    const template = document.getElementById('detail-template');
    const clone = template.content.cloneNode(true);

    const currentCount = container.querySelectorAll('.detail-row').length;
    const newIndex = currentCount;

    clone.querySelector('.row-number').textContent = newIndex + 1;
    clone.querySelector('.supply-date').setAttribute('name', `supplies[${newIndex}][supply_date]`);
    clone.querySelector('.item-name').setAttribute('name', `supplies[${newIndex}][item_name]`);
    clone.querySelector('.quantity').setAttribute('name', `supplies[${newIndex}][quantity]`);
    clone.querySelector('.unit-price').setAttribute('name', `supplies[${newIndex}][unit_price]`);
    clone.querySelector('.total-price').setAttribute('name', `supplies[${newIndex}][total_price]`);
    clone.querySelector('.remarks').setAttribute('name', `supplies[${newIndex}][remarks]`);

    // 合計金額自動計算
    const quantityInput = clone.querySelector('.quantity');
    const unitPriceInput = clone.querySelector('.unit-price');
    const totalPriceInput = clone.querySelector('.total-price');
    quantityInput.addEventListener('input', () => totalPriceInput.value = quantityInput.value * unitPriceInput.value);
    unitPriceInput.addEventListener('input', () => totalPriceInput.value = quantityInput.value * unitPriceInput.value);

    container.appendChild(clone);
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