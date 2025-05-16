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
    ['key' => 'id', 'label' => 'ID'],
    ['key' => 'user.name', 'label' => '申請者'],
    ['key' => 'purchase_date', 'label' => '購入日'],
    ['key' => 'item_name', 'label' => '品名'],
    ['key' => 'quantity', 'label' => '数量'],
    ['key' => 'amount', 'label' => '金額'],
  ],

  'business_trip' => [
    ['key' => 'id', 'label' => 'ID'],
    ['key' => 'user.name', 'label' => '申請者'],
    ['key' => 'business_trip_date', 'label' => '出張日'],
    ['key' => 'departure', 'label' => '出発地'],
    ['key' => 'destination', 'label' => '目的地'],
    ['key' => 'amount', 'label' => '金額'],
  ],

  'entertainment' => [
    ['key' => 'id', 'label' => 'ID'],
    ['key' => 'user.name', 'label' => '申請者'],
    ['key' => 'date', 'label' => '利用日'],
    ['key' => 'client_name', 'label' => '接待相手'],
    ['key' => 'place', 'label' => '場所'],
    ['key' => 'amount', 'label' => '金額'],
  ],
];
