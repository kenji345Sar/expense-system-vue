@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
  <h2 class="text-2xl font-bold mb-6">接待費 新規申請</h2>

  <form method="POST" action="{{ route('entertainment.store') }}">
    @csrf

    <div class="mb-4">
      <label for="description" class="block font-semibold mb-1">申請メモ（任意）</label>
      <textarea id="description" name="description" class="w-full border rounded p-2">{{ old('description') }}</textarea>
    </div>

    {{-- Vueマウント --}}
    <div id="app">
      <expense-form type="entertainment" :initial-items="[]"></expense-form>
    </div>

    <div class="mt-6">
      <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">登録</button>
      <a href="{{ route('entertainment.index') }}" class="ml-4 text-gray-600 hover:underline">戻る</a>
    </div>
  </form>
</div>
@endsection