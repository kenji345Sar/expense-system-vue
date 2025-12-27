@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-semibold mb-6">申請一覧</h2>

    <div class="max-w-7xl mx-auto px-4">

        {{-- 検索フォーム --}}
        <form method="GET" id="search-form" action="{{ route('expenses.all') }}" class="flex flex-wrap gap-4 items-end mb-6">

            {{-- 出力形式 --}}
            <div class="flex flex-col">
                <label for="csv_type" class="block text-sm font-medium text-gray-700 mb-1">出力形式：</label>
                <select name="csv_type" id="csv_type" class="form-select w-48" onchange="submitForm()">
                    <option value="summary" {{ request('csv_type') === 'summary' ? 'selected' : '' }}>伝票単位（合計）</option>
                    <option value="detail" {{ request('csv_type') === 'detail' ? 'selected' : '' }}>明細単位</option>
                </select>
            </div>

            {{-- 種別 --}}
            <div class="flex flex-col">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">種別：</label>
                <select name="type[]" id="type" class="form-multiselect w-64" multiple size="4"
                    onchange="submitForm()">
                    <option value="交通費" {{ collect(request('type'))->contains('交通費') ? 'selected' : '' }}>交通費</option>
                    <option value="備品・消耗品費" {{ collect(request('type'))->contains('備品・消耗品費') ? 'selected' : '' }}>備品・消耗品費
                    </option>
                    <option value="出張旅費" {{ collect(request('type'))->contains('出張旅費') ? 'selected' : '' }}>出張旅費</option>
                    <option value="接待交際費" {{ collect(request('type'))->contains('接待交際費') ? 'selected' : '' }}>接待交際費
                    </option>
                </select>
            </div>

            {{-- 日付（開始） --}}
            <div class="flex flex-col">
                <label class="block text-sm font-medium text-gray-700 mb-1">日付（開始）:</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input w-48"
                    onchange="submitForm()">
            </div>

            {{-- 日付（終了） --}}
            <div class="flex flex-col">
                <label class="block text-sm font-medium text-gray-700 mb-1">日付（終了）:</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input w-48"
                    onchange="submitForm()">
            </div>
        </form>


        {{-- CSV出力ボタン --}}
        <div class="mb-6 text-right">
            <form method="GET" action="{{ route('expenses.export') }}">
                <input type="hidden" name="csv_type" value="{{ request('csv_type') }}">
                @foreach ((array) request('type') as $type)
                    <input type="hidden" name="type[]" value="{{ $type }}">
                @endforeach
                <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    CSV出力
                </button>
            </form>
        </div>

        {{-- テーブル表示 --}}
        @if ($csvType === 'summary')
            <div class="mt-4">



                <table class="min-w-full table-auto border border-gray-300 mb-6">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2 text-left font-semibold">
                                <a
                                    href="{{ route('expenses.all', array_merge(request()->query(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    伝票番号
                                    @if (request('sort') === 'id')
                                        {{ request('direction') === 'asc' ? '↑' : '↓' }}
                                    @endif
                                </a>
                            </th>
                            <th class="border px-4 py-2 text-left font-semibold">
                                <a
                                    href="{{ route('expenses.all', array_merge(request()->query(), ['sort' => 'date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    日付
                                    @if (request('sort') === 'date')
                                        {{ request('direction') === 'asc' ? '↑' : '↓' }}
                                    @endif
                                </a>
                            </th>
                            <th class="border px-4 py-2 text-left font-semibold">種別</th>
                            <th class="border px-4 py-2 text-left font-semibold">申請者</th>
                            <th class="border px-4 py-2 text-right font-semibold">金額</th>
                            <th class="border px-4 py-2 text-left font-semibold">ステータス</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $expense->id }}</td>
                                <td class="border px-4 py-2">{{ $expense->date }}</td>
                                <td class="border px-4 py-2">{{ $expense->expense_type }}</td>
                                <td class="border px-4 py-2">{{ $expense->user->name }}</td>
                                <td class="border px-4 py-2 text-right">{{ number_format($expense->amount) }}</td>
                                <td class="border px-4 py-2">{{ expense_status_label($expense->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex justify-start mt-4">

                    {{ $expenses->appends(request()->query())->links() }}
                </div>
            @else
                <div class="mt-4">
                    {{ $details->appends(request()->query())->links() }}
                </div>
                <table class="min-w-full table-auto border border-gray-300 mb-6">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2 text-left font-semibold">伝票番号</th>
                            <th class="border px-4 py-2 text-left font-semibold">日付</th>
                            <th class="border px-4 py-2 text-left font-semibold">種別</th>
                            <th class="border px-4 py-2 text-left font-semibold">明細内容</th>
                            <th class="border px-4 py-2 text-right font-semibold">金額</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $row['伝票番号'] }}</td>
                                <td class="border px-4 py-2">{{ $row['日付'] }}</td>
                                <td class="border px-4 py-2">{{ $row['種別'] }}</td>
                                <td class="border px-4 py-2">{{ $row['明細内容'] }}</td>
                                <td class="border px-4 py-2 text-right">{{ number_format($row['金額']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex justify-start mt-4">
                    {{ $expenses->appends(request()->query())->links() }}
                </div>
        @endif
        <div class="mt-6 space-y-2">
            <x-action-button :href="route('expenses.menu')" color="blue" class="text-blue-600 font-semibold">
                ← 経費メニューへ戻る
            </x-action-button>
        </div>
    </div>


@endsection



@push('scripts')
    <script>
        function submitForm() {
            document.getElementById('search-form').submit();
        }
    </script>
@endpush
