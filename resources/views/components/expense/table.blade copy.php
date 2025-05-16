@props(['headers', 'rows', 'type', 'relation', 'actions' => true])

@php use App\Helpers\ExpenseFormatter; @endphp

<table class="table-auto w-full border">
  <thead>
    <tr>
      @foreach ($headers as $header)
      <th class="border px-2 py-1">{{ $header['label'] }}</th>
      @endforeach
      @if ($actions)
      <th class="border px-2 py-1">操作</th>
      @endif
    </tr>
  </thead>
  <tbody>

    @foreach ($rows as $row)
    @php
    $details = $row->{$relation};
    $detail = $details->first();

    @endphp
    <tr>
      @foreach ($headers as $header)
      @php
      $source = $header['source'] ?? 'expense';

      if ($source === 'expense') {
      $raw = data_get($row, $header['key']);
      } elseif ($source === 'detail') {
      if ($header['key'] === 'departure') {
      $raw = $detail ? "{$detail->departure} → {$detail->arrival}" : '―';
      } else {
      $raw = $detail?->{$header['key']} ?? '―';
      }
      } else {
      $raw = '―';
      }

      $value = \App\Helpers\ExpenseFormatter::format($raw, $header['formatter'] ?? null);
      @endphp

      <td class="border px-2 py-1">{{ $value }}</td>
      @endforeach


      @if ($actions)
      <td class="border px-2 py-1">
        <a href="{{ route($type . '.edit', $row->id) }}" class="btn-blue">編集</a>
        <a href="{{ route($type . '.apply', $row->id) }}" class="btn-green">申請</a>
      </td>
      @endif
    </tr>

    {{-- 複数明細表示用の行 --}}
    @if ($details->count() === 1)
    @php $detail = $details->first(); @endphp
    <td>{{ $detail->departure }} → {{ $detail->arrival }}</td>
    <td>{{ $detail->route }}</td>
    @else
    <td colspan="2">明細 {{ $details->count() }} 件（合計 {{ number_format($details->sum('amount')) }}円）</td>
    @endif

    @endforeach
  </tbody>
</table>