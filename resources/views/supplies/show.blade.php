<h1>備品・消耗品費 詳細</h1>

<p><strong>日付:</strong> {{ $expense->date }}</p>
<p><strong>品名:</strong> {{ $expense->item_name }}</p>
<p><strong>数量:</strong> {{ $expense->quantity }}</p>
<p><strong>単価:</strong> {{ number_format($expense->unit_price) }}円</p>
<p><strong>合計金額:</strong> {{ number_format($expense->total_price) }}円</p>
<p><strong>備考:</strong> {{ $expense->remarks }}</p>

<a href="{{ route('supplies_expenses.index') }}">← 一覧に戻る</a>