@props(['headers', 'rows', 'type', 'relation', 'actions' => true])

@php use App\Helpers\ExpenseFormatter; @endphp

<table class="table-auto w-full border-separate border-spacing-0 border border-gray-300 text-sm
    text-gray-700">

    <thead class="bg-gray-100">
        <tr>
            @foreach ($headers as $header)
                <th class="border px-3 py-2 font-semibold text-left">{{ $header['label'] }}</th>
            @endforeach
            @if ($actions)
                <th class="border px-3 py-2 font-semibold text-left">操作</th>
            @endif
        </tr>
    </thead>
    <tbody>

        @foreach ($rows as $row)
            @php
                $details = $row->{$relation};
            @endphp

            @foreach ($details as $detail)
                @php
                    static $prevId = null;
                    static $bgToggle = false;
                    static $currentBg = '';

                    $isNewGroup = $prevId !== $detail->expense_id;
                    if ($isNewGroup) {
                        $bgToggle = !$bgToggle;
                        $currentBg = $bgToggle ? 'bg-white' : 'bg-gray-100'; // 色A / 色B の切り替え
                    }
                    $prevId = $detail->expense_id;
                @endphp
                <tr class="hover:bg-gray-50 {{ $currentBg }}">
                    @foreach ($headers as $header)
                        @php
                            $source = $header['source'] ?? 'detail';
                            $raw = '-';

                            if ($source === 'expense') {
                                $raw = data_get($row, $header['key']);
                            } elseif ($source === 'detail') {
                                $raw = $detail?->{$header['key']} ?? '-';
                            }

                            $value = \App\Helpers\ExpenseFormatter::format($raw, $header['formatter'] ?? null);
                        @endphp

                        <td class="border px-3 py-2 ">
                            {{ $value }}
                        </td>
                    @endforeach

                    {{-- 操作 --}}
                    @if ($actions)
                        <td class="border px-3 py-2 space-x-1 text-center">
                            <a href="{{ route($type . '.edit', $row->id) }}"
                                class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded">編集</a>
                            <a href="{{ route($type . '.apply', $row->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">申請</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        @endforeach

    </tbody>

</table>

<div class="mt-6 space-y-2">
    <x-action-button :href="route('expenses.menu')" color="blue" class="text-blue-600 font-semibold">
        ← 経費メニューへ戻る
    </x-action-button>
</div>
