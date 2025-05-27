@extends('layouts.app')

@section('content')
    <h1>全経費一覧</h1>

    <form method="POST" action=""">
        @csrf
        <label>出力形式:</label>
        <select name="csv_type">
            <option value="summary">伝票単位（合計）</option>
            <option value="detail">明細単位</option>
        </select>
        <button type="submit">CSV出力</button>
    </form>



    <table>
        <thead>
            <tr>
                <th>伝票番号</th>
                <th>日付</th>
                <th>種別</th>
                <th>明細内容</th>
                <th>金額</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $row)
                <tr>
                    <td>{{ $row['伝票番号'] }}</td>
                    <td>{{ $row['日付'] }}</td>
                    <td>{{ $row['種別'] }}</td>
                    <td>{{ $row['明細内容'] }}</td>
                    <td>{{ number_format($row['金額']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
