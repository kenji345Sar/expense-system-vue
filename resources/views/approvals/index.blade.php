<h1>承認待ち一覧</h1>

<table>
  <tr>
    <th>日付</th>
    <th>金額</th>
    <th>内容</th>
    <th>区分</th>
    <th>申請者</th>
    <th>操作</th>
  </tr>
  @foreach ($expenses as $expense)
  <tr>
    <td>{{ $expense->date }}</td>
    <td>{{ $expense->amount }}</td>
    <td>{{ $expense->description }}</td>
    <td>{{ $expense->expense_type }}</td>
    <td>{{ $expense->user->name ?? '-' }}</td>
    <td>
      <form action="{{ route('approvals.approve', $expense->id) }}" method="POST" style="display:inline">
        @csrf
        <button type="submit">承認</button>
      </form>
      <form action="{{ route('approvals.return', $expense->id) }}" method="POST" style="display:inline">
        @csrf
        <input type="text" name="comment" placeholder="差戻し理由">
        <button type="submit">差戻し</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>