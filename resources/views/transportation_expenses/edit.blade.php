@extends('layouts.app')

@section('content')
<div class="container">
    <h1>交通費申請 編集</h1>

    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div id="details" x-data="{ rows: @json($expense->transportationExpenses) }">
            <template x-for="(row, index) in rows" :key="index">
                <div class="border p-4 mb-4 rounded">
                    <input type="hidden" :name="'transportation_expenses[' + index + '][id]'" x-bind:value="row.id">
                    <label>利用日</label>
                    <input type="date" :name="'transportation_expenses[' + index + '][use_date]'" x-bind:value="row.use_date">
                    <label>出発地</label>
                    <input type="text" :name="'transportation_expenses[' + index + '][departure]'" x-bind:value="row.departure">
                    <label>到着地</label>
                    <input type="text" :name="'transportation_expenses[' + index + '][arrival]'" x-bind:value="row.arrival">
                    <label>経路</label>
                    <input type="text" :name="'transportation_expenses[' + index + '][route]'" x-bind:value="row.route">
                    <label>金額</label>
                    <input type="number" :name="'transportation_expenses[' + index + '][amount]'" x-bind:value="row.amount">
                </div>
            </template>
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection