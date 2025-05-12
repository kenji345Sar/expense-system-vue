@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">交通費 編集フォーム</h2>

    <form method="POST" action="{{ route('transportation.update', $transportation->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="description" class="block font-semibold mb-1">申請メモ（任意）</label>
            <textarea id="description" name="description" class="w-full border rounded p-2">{{ old('description', $transportation->description) }}</textarea>
        </div>

        {{-- Vueマウントポイント --}}
        <div id="app">
            <expense-form
                type="transportation"
                :initial-items='@json($transportation->transportationExpenses)'></expense-form>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新</button>
            <a href="{{ route('transportation.index') }}" class="ml-4 text-gray-600 hover:underline">戻る</a>
        </div>
    </form>
</div>
@endsection