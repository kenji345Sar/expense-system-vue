@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">
  <h2 class="text-2xl font-bold mb-6">備品・消耗品費申請フォーム</h2>

  @if ($errors->any())
  <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
    <ul class="list-disc list-inside">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('supplies_expenses.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
      <label for="date" class="block font-medium">日付</label>
      <input type="date" name="date" id="date" value="{{ old('date') }}"
        class="w-60 border rounded px-3 py-2" required>
    </div>

    <div>
      <label for="item_name" class="block font-medium">品名</label>
      <input type="text" name="item_name" id="item_name" value="{{ old('item_name') }}"
        class="w-full border rounded px-3 py-2" placeholder="例：USBメモリ" required>
    </div>

    <div class="flex space-x-4">
      <div class="w-1/2">
        <label for="quantity" class="block font-medium">数量</label>
        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}"
          class="w-full border rounded px-3 py-2" required>
      </div>
      <div class="w-1/2">
        <label for="unit_price" class="block font-medium">単価</label>
        <input type="number" name="unit_price" id="unit_price" value="{{ old('unit_price') }}"
          class="w-full border rounded px-3 py-2" required>
      </div>
    </div>

    <div>
      <label for="total_price" class="block font-medium">合計金額</label>
      <input type="number" name="total_price" id="total_price" value="{{ old('total_price') }}"
        class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
      <label for="note" class="block font-medium">備考</label>
      <textarea name="note" id="note" rows="3"
        class="w-full border rounded px-3 py-2"
        placeholder="用途や補足があれば記載">{{ old('note') }}</textarea>
    </div>

    <div class="text-right">
      <button type="submit"
        class="px-5 py-2 bg-blue-600 text-black font-semibold rounded hover:bg-blue-500">
        申請
      </button>
    </div>
  </form>
</div>
@endsection