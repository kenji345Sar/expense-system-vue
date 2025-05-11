{{-- resources/views/supplies_expenses/_form.blade.php --}}
@csrf
@if(isset($edit) && $edit)
@method('PUT')
@endif

<div>
  <label for="date" class="block font-medium">日付</label>
  <input type="date" name="date" id="date"
    value="{{ old('date', $supplies_expense->date ?? '') }}"
    class="w-60 border rounded px-3 py-2" required>
</div>

<div>
  <label for="item_name" class="block font-medium">品名</label>
  <input type="text" name="item_name" id="item_name"
    value="{{ old('item_name', $supplies_expense->item_name ?? '') }}"
    class="w-full border rounded px-3 py-2" placeholder="例：USBメモリ" required>
</div>

<div class="flex space-x-4">
  <div class="w-1/2">
    <label for="quantity" class="block font-medium">数量</label>
    <input type="number" name="quantity" id="quantity"
      value="{{ old('quantity', $supplies_expense->quantity ?? '') }}"
      class="w-full border rounded px-3 py-2" required>
  </div>
  <div class="w-1/2">
    <label for="unit_price" class="block font-medium">単価</label>
    <input type="number" name="unit_price" id="unit_price"
      value="{{ old('unit_price', $supplies_expense->unit_price ?? '') }}"
      class="w-full border rounded px-3 py-2" required>
  </div>
</div>

<div>
  <label for="total_price" class="block font-medium">合計金額</label>
  <input type="number" name="total_price" id="total_price"
    value="{{ old('total_price', $supplies_expense->total_price ?? '') }}"
    class="w-full border rounded px-3 py-2" required>
</div>

<div>
  <label for="note" class="block font-medium">備考</label>
  <textarea name="note" id="note" rows="3"
    class="w-full border rounded px-3 py-2">{{ old('note', $supplies_expense->note ?? '') }}</textarea>
</div>