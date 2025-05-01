<h1>備品・消耗品費 一覧</h1>

@if (session('success'))
<p style="color: green;">{{ session('success') }}</p>
@endif

<a href="{{ route('supplies_expenses.create') }}">新規作成</a>

<table border="1">
  <thead>
    <tr>
      <th>日付</th>
      <th>品名</th>
      <th>数量</th>
      <th>単価</th>
      <th>合計金額</th>
      <th>備考</th>
      <th>操作</th> <!-- 操作列を追加 -->
    </tr>
  </thead>
  <tbody>
    @foreach ($expenses as $expense)
    <tr>
      <td>{{ $expense->date }}</td>
      <td>{{ $expense->item_name }}</td>
      <td>{{ $expense->quantity }}</td>
      <td>{{ number_format($expense->unit_price) }}円</td>
      <td>{{ number_format($expense->total_price) }}円</td>
      <td>{{ $expense->remarks }}</td>
      <td>
        <a href="{{ route('supplies_expenses.show', $expense->id) }}">詳細</a>
        <a href="{{ route('supplies_expenses.edit', $expense->id) }}">編集</a>

        <form action="{{ route('supplies_expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('削除してよろしいですか？')">削除</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>