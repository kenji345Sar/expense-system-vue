<?php

namespace App\Services;

use App\Models\Expense;

class ExpenseDetailExportService
{
  public function getUnifiedDetails(array $filters = []): \Illuminate\Support\Collection
  {

    $results = collect();

    $typesToInclude = [];

    if (empty($filters['type'])) {
      $typesToInclude = ['交通費', '備品・消耗品費', '出張旅費', '接待交際費'];
    } elseif (is_array($filters['type'])) {
      $typesToInclude = $filters['type'];
    } else {
      $typesToInclude[] = $filters['type'];
    }

    // 各変数を空のコレクションで初期化
    $transportations = collect();
    $supplies = collect();
    $entertainments = collect();
    $businessTrips = collect();

    if (in_array('transportation', $typesToInclude)) {
      $query = Expense::with('transportationExpenses')
        ->where('expense_type', 'transportation');

      if (!empty($filters['date_from'])) {
        $query->whereDate('date', '>=', $filters['date_from']);
      }

      if (!empty($filters['date_to'])) {
        $query->whereDate('date', '<=', $filters['date_to']);
      }
      $transportations = $query->get()
        ->flatMap(function ($expense) {
          return $expense->transportationExpenses->map(function ($detail) use ($expense) {
            return [
              '伝票番号' => $expense->id,
              '日付' => $expense->date,
              '種別' => '交通費',
              '明細内容' => "{$detail->from} → {$detail->to}",
              '金額' => $detail->amount,
            ];
          });
        });
    }

    if (in_array('supplies', $typesToInclude)) {
      $supplies = Expense::with('suppliesExpenses')
        ->where('expense_type', 'supplies')
        ->get()
        ->flatMap(function ($expense) {
          return $expense->suppliesExpenses->map(function ($detail) use ($expense) {
            return [
              '伝票番号' => $expense->id,
              '日付' => $expense->date,
              '種別' => '備品',
              '明細内容' => $detail->item_name ?? '（備品名不明）',
              '金額' => $detail->amount,
            ];
          });
        });
    }

    if (in_array('entertainment', $typesToInclude)) {
      $entertainments = Expense::with('entertainmentExpenses')
        ->where('expense_type', 'entertainment')
        ->get()
        ->flatMap(function ($expense) {
          return $expense->entertainmentExpenses->map(function ($detail) use ($expense) {
            return [
              '伝票番号' => $expense->id,
              '日付' => $expense->date,
              '種別' => '接待交際費',
              '明細内容' => $detail->content ?? '（内容未入力）',
              '金額' => $detail->amount,
            ];
          });
        });
    }

    if (in_array('business_trip', $typesToInclude)) {
      $businessTrips = Expense::with('businessTripExpenses')
        ->where('expense_type', 'business_trip')
        ->get()
        ->flatMap(function ($expense) {
          return $expense->businessTripExpenses->map(function ($detail) use ($expense) {
            return [
              '伝票番号' => $expense->id,
              '日付' => $expense->date,
              '種別' => '出張旅費',
              '明細内容' => $detail->description ?? '（内容未入力）',
              '金額' => $detail->amount,
            ];
          });
        });
    }

    // return $results->sortByDesc('日付')->values();

    // すべてマージして返す
    return collect()
      ->merge($transportations)
      ->merge($supplies)
      ->merge($entertainments)
      ->merge($businessTrips)
      ->sortBy('伝票番号')
      ->values(); // 並べ直し

  }
}
