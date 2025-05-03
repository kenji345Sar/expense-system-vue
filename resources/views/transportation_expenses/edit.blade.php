@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">交通費 編集</h2>

    @include('transportation_expenses._errors')

    <form action="{{ route('transportation_expenses.update', $transportation_expense->id) }}" method="POST" class="space-y-4">
        @php $edit = true; @endphp
        @include('transportation_expenses._form')

        <div class="flex justify-between">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新する</button>
            <a href="{{ route('transportation_expenses.index') }}" class="text-blue-500">← 一覧に戻る</a>
        </div>
    </form>
</div>
@endsection