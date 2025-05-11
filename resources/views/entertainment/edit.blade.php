@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">
  <h2 class="text-2xl font-bold mb-6">接待交際費 編集</h2>

  <x-error-messages />

  <form action="{{ route('entertainment_expenses.update', $entertainment_expense->id) }}" method="POST" class="space-y-4" novalidate>
    @php $edit = true; @endphp
    @include('entertainment_expenses._form')

    <div class="flex justify-between">
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新する</button>
      <a href="{{ route('entertainment_expenses.index') }}" class="text-blue-500">← 一覧に戻る</a>
    </div>
  </form>
</div>
@endsection