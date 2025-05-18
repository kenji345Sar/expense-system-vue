@extends('layouts.app')

@section('title', '経費一覧')

@section('content')
    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">経費一覧（{{ $type }}）</h1>

        <x-alert-message />

        <div class="mb-4">
            <x-action-button :href="route($type . '.create')" color="blue" class="text-xl text-black-800 font-semibold">
                ＋ 新規申請
            </x-action-button>
        </div>

        @if (auth()->user()?->is_admin)
            <p class="text-sm text-gray-500 mb-4">※ 管理者モード：全ユーザのデータを表示中</p>
        @endif

        {{-- 共通化されたテーブルコンポーネント --}}
        <x-expenses.table :headers="$headers" :rows="$expenses" :type="$type" :relation="$relation" />
    </div>
@endsection
