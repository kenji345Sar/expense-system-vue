{{-- resources/views/supplies_expenses/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">
  <h2 class="text-2xl font-bold mb-6">備品・消耗品費 編集</h2>

  {{-- エラーメッセージ表示（共通化） --}}
  @include('supplies_expenses._errors')

  <form action="{{ route('supplies_expenses.update', $supplies_expense->id) }}" method="POST" class="space-y-4">
    @php $edit = true; @endphp
    @include('supplies_expenses._form')

    <div class="flex justify-between">
      <button type="submit" class="bg-blue-500 text-block px-4 py-2 rounded">更新する</button>
      <a href="{{ route('supplies_expenses.index') }}" class="text-blue-500">← 一覧に戻る</a>
    </div>
  </form>
</div>
@endsection