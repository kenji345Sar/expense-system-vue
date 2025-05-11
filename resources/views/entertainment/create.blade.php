@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">
  <h2 class="text-2xl font-bold mb-6">接待交際費申請フォーム</h2>

  @include('entertainment_expenses._errors')

  <form action="{{ route('entertainment_expenses.store') }}" method="POST" class="space-y-4" novalidate>
    @include('entertainment_expenses._form')

    <div class="flex justify-between">
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">申請</button>
    </div>
  </form>
</div>
@endsection