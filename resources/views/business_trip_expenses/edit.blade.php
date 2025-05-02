@extends('layouts.app')

@section('content')
<h1>出張旅費 編集</h1>

<form action="{{ route('business_trip_expenses.update', $expense->id) }}" method="POST">
  @csrf
  @method('PUT')

  <p>日付: <input type="date" name="business_trip_date" value="{{ old('date', $expense->business_trip_date) }}"></p>
  <p>出発地: <input type="text" name="departure" value="{{ old('departure', $expense->departure) }}"></p>
  <p>到着地: <input type="text" name="destination" value="{{ old('destination', $expense->destination) }}"></p>
  <p>目的: <input type="text" name="purpose" value="{{ old('purpose', $expense->purpose) }}"></p>
  <p>交通手段: <input type="text" name="transportation" value="{{ old('transportation', $expense->transportation) }}"></p>
  <p>宿泊有無: <input type="checkbox" name="is_stay" value="1" {{ old('is_stay', $expense->is_stay) ? 'checked' : '' }}></p>
  <p>金額: <input type="number" name="amount" value="{{ old('amount', $expense->amount) }}"></p>
  <p>備考: <textarea name="remarks">{{ old('remarks', $expense->remarks) }}</textarea></p>

  <button type="submit">更新</button>
</form>

<p><a href="{{ route('business_trip_expenses.index') }}">一覧に戻る</a></p>
@endsection