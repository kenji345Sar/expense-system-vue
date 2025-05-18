<?php

return [
  'transportation' => [
    ['key' => 'id', 'label' => 'ID', 'source' => 'expense'],
    ['key' => 'user.name', 'label' => '申請者', 'source' => 'expense'],
    ['key' => 'use_date', 'label' => '利用日', 'source' => 'detail', 'formatter' => 'date'],
    ['key' => 'departure', 'label' => '区間', 'source' => 'detail'],
    ['key' => 'route', 'label' => '経路', 'source' => 'detail'],
    ['key' => 'amount', 'label' => '金額', 'source' => 'expense', 'formatter' => 'yen'],
  ],
  'supplies' => [
    ['key' => 'id', 'label' => 'ID', 'source' => 'expense'],
    ['key' => 'user.name', 'label' => '申請者', 'source' => 'expense'],
    ['key' => 'supply_date', 'label' => '購入日', 'source' => 'detail', 'formatter' => 'date', 'type' => 'date'],
    ['key' => 'item_name', 'label' => '品名', 'source' => 'detail'],
    ['key' => 'quantity', 'label' => '数量', 'source' => 'detail', 'type' => 'number'],
    ['key' => 'unit_price', 'label' => '単価', 'source' => 'detail', 'type' => 'number'],
    ['key' => 'remarks', 'label' => '備考', 'source' => 'detail'],
    ['key' => 'total_price', 'label' => '金額', 'source' => 'detail', 'formatter' => 'yen'],
  ],
  'business_trip' => [
    ['key' => 'id', 'label' => 'ID', 'source' => 'expense'],
    ['key' => 'user.name', 'label' => '申請者', 'source' => 'expense'],
    ['key' => 'business_trip_date', 'label' => '出張日', 'source' => 'detail', 'formatter' => 'date'],
    ['key' => 'departure', 'label' => '出発地', 'source' => 'detail'],
    ['key' => 'destination', 'label' => '到着地', 'source' => 'detail'],
    ['key' => 'transportation', 'label' => '目的', 'source' => 'detail'],
    ['key' => 'remarks', 'label' => '備考', 'source' => 'detail'],
    ['key' => 'amount', 'label' => '金額', 'source' => 'expense', 'formatter' => 'yen'],
  ],

  'entertainment' => [
    ['key' => 'id', 'label' => 'ID'],
    ['key' => 'user.name', 'label' => '申請者'],
    ['key' => 'date', 'label' => '利用日'],
    ['key' => 'client_name', 'label' => '接待相手'],
    ['key' => 'place', 'label' => '場所'],
    ['key' => 'amount', 'label' => '金額'],
  ],
  'entertainment' => [
    ['key' => 'id', 'label' => 'ID', 'source' => 'expense'],
    ['key' => 'user.name', 'label' => '申請者', 'source' => 'expense'],
    ['key' => 'entertainment_date', 'label' => '利用日', 'source' => 'detail', 'formatter' => 'date'],
    ['key' => 'client_name', 'label' => '接待相手', 'source' => 'detail'],
    ['key' => 'place', 'label' => '場所', 'source' => 'detail'],
    ['key' => 'content', 'label' => '内容', 'source' => 'detail'],
    ['key' => 'amount', 'label' => '金額', 'source' => 'expense', 'formatter' => 'yen'],
  ],
];
