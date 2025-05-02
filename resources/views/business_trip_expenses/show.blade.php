@extends('layouts.app')

@section('content')
<h1>出張旅費 詳細</h1>

<table border="1">
  <tr>
    <th>日付</th>
    <td>{{ $expense->business_trip_date }}</td>
  </tr>
  <tr>
    <th>出発地</th>
    <td>{{ $expense->departure }}</td>
  </tr>
  <tr>
    <th>到着地</th>
    <td>{{ $expense->destination }}</td>
  </tr>
  <tr>
    <th>目的</th>
    <td>{{ $expense->purpose }}</td>
  </tr>
  <tr>
    <th>交通手段</th>
    <td>{{ $expense->transportation }}</td>
  </tr>
  <tr>
    <th>宿泊有無</th>
    <td>{{ $expense->is_stay ? '有' : '無' }}</td>
  </tr>
  <tr>
    <th>金額</th>
    <td>{{ number_format($expense->amount) }}円</td>
  </tr>
  <tr>
    <th>備考</th>
    <td>{{ $expense->remarks }}</td>
  </tr>
</table>

<p><a href="{{ route('business_trip_expenses.index') }}">一覧に戻る</a></p>
@endsection