@extends('layouts.app')

@section('title', '出張旅費一覧')

@section('content')
<h1>出張旅費一覧</h1>
@foreach (['success', 'error', 'warning', 'info'] as $msg)
@if (session($msg))
<p class="{{ $msg }}">{{ session($msg) }}</p>
@endif
@endforeach

<a href="{{ route('business_trip_expenses.create') }}">新規作成</a>

<table border="1">
  <thead>
    <tr>

      <th>日付</th>
      <th>出発地</th>
      <th>到着地</th>
      <th>交通手段</th>
      <th>目的</th>
      <th>金額</th>
      <th>備考</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($expenses as $expense)
    <tr>
      <td>{{ $expense->business_trip_date }}</td>
      <td>{{ $expense->departure }}</td>
      <td>{{ $expense->destination }}</td>
      <td>{{ $expense->transportation }}</td>
      <td>{{ $expense->purpose }}</td>
      <td>{{ number_format($expense->amount) }}円</td>
      <td>{{ $expense->remarks }}</td>
      <td>
        <a href="{{ route('business_trip_expenses.show', $expense->id) }}">詳細</a>
        <a href="{{ route('business_trip_expenses.edit', $expense->id) }}">編集</a>
        <form action="{{ route('business_trip_expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit">削除</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection