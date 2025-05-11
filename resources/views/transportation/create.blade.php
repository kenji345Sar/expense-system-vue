@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8" x-data="transportationForm()" x-init="init()">
    <h2 class="text-2xl font-bold mb-6">交通費申請フォーム</h2>

    <form method="POST" action="{{ route('transportation.store') }}">
        @csrf

        <!-- 備考 -->
        <x-form.textarea name="note" label="申請メモ（任意）" />

        <!-- 明細 -->
        <template x-for="(row, index) in rows" :key="index">
            <div class="border p-4 mb-4 rounded">
                <h4 class="font-bold mb-2">交通費 <span x-text="index + 1"></span></h4>

                <x-form.input :name="`transportation_expenses[\${index}][use_date]`" label="利用日" type="date" required />
                <x-form.input :name="`transportation_expenses[\${index}][departure]`" label="出発地" required />
                <x-form.input :name="`transportation_expenses[\${index}][arrival]`" label="到着地" required />
                <x-form.input :name="`transportation_expenses[\${index}][route]`" label="経路" />
                <x-form.input :name="`transportation_expenses[\${index}][amount]`" label="金額" type="number" required />
                <x-form.input :name="`transportation_expenses[\${index}][remarks]`" label="備考（任意）" />

                <button type="button"
                    @click="if (confirm('この行を削除してもよろしいですか？')) rows.splice(index, 1)"
                    x-show="rows.length > 1"
                    class="bg-red-500 text-white px-2 py-1 rounded mt-2">
                    行を削除
                </button>
            </div>
        </template>

        <!-- 行追加ボタン -->
        <div class="mb-4">
            <button type="button" @click="rows.push({})"
                class="bg-blue-500 text-white px-4 py-2 rounded">行を追加</button>
        </div>

        <div class="flex gap-4 mt-6">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                登録する
            </button>
            <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                戻る
            </a>
        </div>
    </form>
</div>

<script>
    function transportationForm() {
        return {
            rows: [],
            initialized: false,
            init() {
                if (!this.initialized) {
                    this.rows.push({});
                    this.initialized = true;
                }
            }
        };
    }
</script>
@endsection