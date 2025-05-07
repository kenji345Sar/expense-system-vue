@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8" x-data="transportationForm()" x-init="init()">
    <h2 class="text-2xl font-bold mb-6">交通費申請フォーム</h2>

    <form method="POST" action="{{ route('transportation_expenses.store') }}">
        @csrf

        <!-- 備考 -->
        <div class="mb-4">
            <label class="block font-bold mb-1">申請メモ（任意）</label>
            <textarea name="note" class="border rounded w-full p-2"></textarea>
        </div>

        <!-- 明細 -->
        <template x-for="(row, index) in rows" :key="index">
            <div class="border p-4 mb-4 rounded">
                <h4 class="font-bold mb-2">交通費 <span x-text="index + 1"></span></h4>

                <input type="date" :name="`transportation_expenses[${index}][use_date]`"
                    class="border p-2 w-full mb-2" placeholder="利用日">

                <input type="text" :name="`transportation_expenses[${index}][departure]`"
                    class="border p-2 w-full mb-2" placeholder="出発地">

                <input type="text" :name="`transportation_expenses[${index}][arrival]`"
                    class="border p-2 w-full mb-2" placeholder="到着地">

                <input type="text" :name="`transportation_expenses[${index}][route]`"
                    class="border p-2 w-full mb-2" placeholder="経路">

                <input type="number" :name="`transportation_expenses[${index}][amount]`"
                    class="border p-2 w-full mb-2" placeholder="金額">

                <input type="text" :name="`transportation_expenses[${index}][remarks]`"
                    class="border p-2 w-full mb-2" placeholder="備考（任意）">

                <button type="button" @click="rows.splice(index, 1)"
                    class="bg-red-500 text-black px-2 py-1 rounded mt-2">行を削除</button>
            </div>
        </template>

        <div class="mb-4">
            <button type="button" @click="rows.push({})"
                class="bg-blue-500 text-white px-4 py-2 rounded">行を追加</button>
        </div>

        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded">申請する</button>
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