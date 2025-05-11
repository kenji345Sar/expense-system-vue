@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">
  <h2 class="text-2xl font-bold mb-6">出張旅費 編集フォーム</h2>

  @if (session('success'))
  <p class="mb-4 p-2 rounded bg-green-100 text-green-800">
    {{ session('success') }}
  </p>
  @endif

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


  <form method="POST" action="{{ url('/expenses/business_trip/' . $business_trip->id) }}">

    @csrf
    @method('PUT')

    <div class="mb-4">
      <label class="block font-bold mb-1">申請メモ（任意）</label>
      <textarea name="description" class="border w-full p-2 rounded">{{ old('description', $business_trip->description) }}</textarea>
    </div>

    {{-- 複数明細フォーム --}}
    @foreach ($business_trip->businessTripExpenses as $index => $detail)
    <div class="border p-4 mb-4 rounded">
      <h4 class="font-bold mb-2">明細 {{ $index + 1 }}</h4>

      <div class="mb-4">
        <label class="block font-bold mb-1">利用日</label>
        <input type="date"
          name="business_trip_expenses[{{ $index }}][business_trip_date]"
          value="{{ old("business_trip_expenses.$index.business_trip_date", $detail->business_trip_date) }}"
          class="w-full border rounded p-2"
          required>

      </div>

      <div class="mb-4">
        <label class="block font-bold mb-1">出発地</label>
        <input type="text"
          name="business_trip_expenses[{{ $index }}][departure]"
          value="{{ old("business_trip_expenses.$index.departure", $detail->departure) }}"
          class="w-full border rounded p-2"
          required>

      </div>

      <div class="mb-4">
        <label class="block font-bold mb-1">到着地</label>
        <input type="text"
          name="business_trip_expenses[{{ $index }}][destination]"
          value="{{ old("business_trip_expenses.$index.destination", $detail->destination) }}"
          class="w-full border rounded p-2"
          required>

      </div>

      <div class="mb-4">
        <label class="block font-bold mb-1">目的</label>
        <input type="text"
          name="business_trip_expenses[{{ $index }}][purpose]"
          value="{{ old("business_trip_expenses.$index.purpose", $detail->purpose) }}"
          class="w-full border rounded p-2">

      </div>

      <div class="mb-4">
        <label class="block font-bold mb-1">金額</label>
        <input type="number"
          name="business_trip_expenses[{{ $index }}][amount]"
          value="{{ old("business_trip_expenses.$index.amount", $detail->amount) }}"
          class="w-full border rounded p-2"
          required>

      </div>

      <div class="mb-4">
        <label class="block font-bold mb-1">備考</label>
        <textarea name="business_trip_expenses[{{ $index }}][note]"
          class="w-full border rounded p-2">{{ old("business_trip_expenses.$index.note", $detail->note) }}</textarea>

      </div>

      <input type="hidden" name="business_trip_expenses[{{ $index }}][id]" value="{{ $detail->id }}">
    </div>
    @endforeach

    <div class="flex gap-4 mt-6">
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        更新
      </button>
      <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
        戻る
      </a>
    </div>
  </form>
</div>
@endsection