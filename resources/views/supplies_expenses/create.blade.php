{{-- resources/views/supplies_expenses/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">
  <h2 class="text-2xl font-bold mb-6">備品・消耗品費申請フォーム</h2>

  {{-- エラーメッセージ表示（共通化） --}}
  <x-error-messages />
  <form action="{{ route('supplies_expenses.store') }}" method="POST" class="space-y-4" novalidate>
    @include('supplies_expenses._form')

    <div class="flex justify-between">
      <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded">申請</button>
    </div>
  </form>
</div>
@endsection