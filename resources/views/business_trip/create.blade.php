<!-- resources/views/business_trip/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
  <h2 class="text-2xl font-bold mb-6">出張旅費 新規フォーム</h2>

  <form method="POST" action="{{ route('business_trip.store') }}">
    @csrf

    <div class="mb-4">
      <label for="description">申請メモ（任意）</label>
      <textarea id="description" name="description" class="w-full border rounded"></textarea>
    </div>

    <div id="app">
      <business-trip-form :initial-items='[]'></business-trip-form>
    </div>

    <div class="mt-6">
      <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">登録</button>
      <a href="{{ route('business_trip.index') }}" class="ml-4 text-gray-600 hover:underline">戻る</a>
    </div>
  </form>
</div>
@endsection