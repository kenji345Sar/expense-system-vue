<h1>申請内容を編集</h1>
<form action="{{ route('transportation.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>利用日: <input type="date" name="use_date" value="{{ $item->use_date }}"></label><br>
    <label>出発地: <input type="text" name="departure" value="{{ $item->departure }}"></label><br>
    <label>到着地: <input type="text" name="arrival" value="{{ $item->arrival }}"></label><br>
    <label>経路: <input type="text" name="route" value="{{ $item->route }}"></label><br>
    <label>金額: <input type="number" name="amount" value="{{ $item->amount }}"></label><br>
    <label>備考:
        <textarea name="remarks">{{ $item->remarks }}</textarea>
    </label><br>
    <button type="submit">更新する</button>
</form>

<p><a href="{{ route('transportation.show', $item->id) }}">← 詳細に戻る</a></p>
