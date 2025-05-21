<?php

return [
  'transportation' => [
    ['key' => 'id', 'label' => 'ID', 'source' => 'expense', 'required' => true],
    ['key' => 'user.name', 'label' => '申請者', 'source' => 'expense', 'required' => true],
    ['key' => 'use_date', 'label' => '利用日', 'source' => 'detail', 'formatter' => 'date', 'type' => 'date', 'required' => true],
    ['key' => 'departure', 'label' => '出発地', 'source' => 'detail', 'required' => true],
    ['key' => 'arrival', 'label' => '到着地', 'source' => 'detail', 'required' => true],
    ['key' => 'route', 'label' => '経路', 'source' => 'detail', 'required' => true],
    ['key' => 'amount', 'label' => '金額', 'source' => 'expense', 'formatter' => 'yen', 'type' => 'number', 'required' => true],
  ],
  'supplies' => [
    ['key' => 'id', 'label' => 'ID', 'source' => 'expense', 'required' => true],
    ['key' => 'user.name', 'label' => '申請者', 'source' => 'expense', 'required' => true],
    ['key' => 'supply_date', 'label' => '購入日', 'source' => 'detail', 'formatter' => 'date', 'type' => 'date', 'required' => true],
    ['key' => 'item_name', 'label' => '品名', 'source' => 'detail', 'required' => true],
    ['key' => 'quantity', 'label' => '数量', 'source' => 'detail', 'type' => 'number', 'required' => true],
    ['key' => 'unit_price', 'label' => '単価', 'source' => 'detail', 'type' => 'number', 'required' => true],
    ['key' => 'remarks', 'label' => '備考', 'source' => 'detail', 'required' => false],
    ['key' => 'total_price', 'label' => '金額', 'source' => 'detail', 'formatter' => 'yen', 'type' => 'number', 'required' => true],
  ],
  'business_trip' => [
    ['key' => 'id', 'label' => 'ID', 'source' => 'expense', 'required' => true],
    ['key' => 'user.name', 'label' => '申請者', 'source' => 'expense', 'required' => true],
    ['key' => 'business_trip_date', 'label' => '出張日', 'source' => 'detail', 'formatter' => 'date', 'type' => 'date', 'required' => true],
    ['key' => 'departure', 'label' => '出発地', 'source' => 'detail', 'required' => true],
    ['key' => 'destination', 'label' => '到着地', 'source' => 'detail', 'required' => true],
    ['key' => 'purpose', 'label' => '目的', 'source' => 'detail', 'required' => true],
    ['key' => 'remarks', 'label' => '備考', 'source' => 'detail', 'required' => false],
    ['key' => 'amount', 'label' => '金額', 'source' => 'expense', 'formatter' => 'yen', 'type' => 'number', 'required' => true],
  ],
  'entertainment' => [
    ['key' => 'id', 'label' => 'ID', 'source' => 'expense', 'required' => true],
    ['key' => 'user.name', 'label' => '申請者', 'source' => 'expense', 'required' => true],
    ['key' => 'entertainment_date', 'label' => '利用日', 'source' => 'detail', 'formatter' => 'date', 'type' => 'date', 'required' => true],
    ['key' => 'client_name', 'label' => '接待相手', 'source' => 'detail', 'required' => true],
    ['key' => 'place', 'label' => '場所', 'source' => 'detail', 'required' => true],
    ['key' => 'content', 'label' => '内容', 'source' => 'detail', 'required' => true],
    ['key' => 'amount', 'label' => '金額', 'source' => 'expense', 'formatter' => 'yen', 'type' => 'number', 'required' => true],
  ],
];
