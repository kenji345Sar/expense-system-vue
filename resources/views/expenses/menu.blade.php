@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4">

        <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">経費精算メニュー</h1>
            <ul class="list-none pl-0">
                <li class="mb-2"><a href="{{ route('business_trip.index') }}"
                        class="text-blue-600 hover:underline">出張旅費申請</a></li>
                <li class="mb-2"><a href="{{ route('supplies.index') }}" class="text-blue-600 hover:underline">備品・消耗品費申請</a>
                </li>
                <li class="mb-2"><a href="{{ route('entertainment.index') }}"
                        class="text-blue-600 hover:underline">接待交際費申請</a></li>
                <li class="mb-2"><a href="{{ route('transportation.index') }}"
                        class="text-blue-600 hover:underline">交通費申請</a></li>
                <li class="mb-2">
                    <a href="{{ route('expenses.all') }}" class="text-blue-500">全申請一覧</a>
                </li>
            </ul>
        </div>
    @endsection
