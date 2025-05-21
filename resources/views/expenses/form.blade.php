@extends('layouts.app')

@section('content')
    <div id="app" class="max-w-3xl mx-auto py-6">
        <h2 class="text-xl font-bold mb-4">{{ $pageTitle }}</h2>
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>・{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ $formAction }}">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="mb-4">
                <label class="block mb-1">申請メモ（任意）</label>
                <textarea name="memo" class="form-input w-full">{{ old('memo', $memo ?? '') }}</textarea>
            </div>

            <!-- prettier-ignore -->
            <expense-form-unify
            :initial-items="{{ json_encode(old('details', $details ?? [])) }}"
            :fields="{{ json_encode($fields) }}"
            form-title="{{ $formTitle }}"
            namespace="details">
            </expense-form-unify>

            <div class="mt-6">
                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded">
                    {{ $isEdit ? '更新' : '登録' }}
                </button>
                <a href="{{ $backUrl }}" class="ml-4 text-gray-600 hover:underline">戻る</a>
            </div>
        </form>
    </div>
@endsection
