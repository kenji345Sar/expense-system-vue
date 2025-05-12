@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
  <h2 class="text-2xl font-bold mb-6">出張旅費 編集フォーム</h2>

  <form method="POST" action="{{ route('business_trip.update', $business_trip->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
      <label for="description" class="block font-semibold mb-1">申請メモ（任意）</label>
      <textarea id="description" name="description" class="w-full border rounded p-2">{{ old('description', $business_trip->description) }}</textarea>
    </div>

    {{-- Vueマウント --}}
    <div id="app">
      <business-trip-edit-form :initial-items='@json($business_trip->businessTripExpenses)'></business-trip-edit-form>
    </div>

    <div class="mt-6">
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新</button>
      <a href="{{ route('business_trip.index') }}" class="ml-4 text-gray-600 hover:underline">戻る</a>
    </div>
  </form>
</div>
@endsection