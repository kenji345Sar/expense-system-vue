<?php

namespace App\Services;

use App\Models\Expense;

class ExpenseDetailExportService
{
  public function getUnifiedDetails(array $filters = []): \Illuminate\Support\Collection
  {
    $typesToInclude = [];

    if (empty($filters['type'])) {
      $typesToInclude = ['transportation', 'supplies', 'business_trip', 'entertainment'];
    } elseif (is_array($filters['type'])) {
      $typesToInclude = $filters['type'];
    } else {
      $typesToInclude[] = $filters['type'];
    }

    $results = collect();

    if (in_array('transportation', $typesToInclude)) {
      $results = $results->merge($this->getExpenses(
        'transportation',
        'transportationExpenses',
        $filters,
        fn($expense, $detail) => [
          '伝票番号' => $expense->id,
          '日付' => $expense->date,
          '種別' => '交通費',
          '明細内容' => "{$detail->from} → {$detail->to}",
          '金額' => $detail->amount,
        ]
      ));
    }

    if (in_array('supplies', $typesToInclude)) {
      $results = $results->merge($this->getExpenses(
        'supplies',
        'suppliesExpenses',
        $filters,
        fn($expense, $detail) => [
          '伝票番号' => $expense->id,
          '日付' => $expense->date,
          '種別' => '備品',
          '明細内容' => $detail->item_name ?? '（備品名不明）',
          '金額' => $detail->amount,
        ]
      ));
    }

    if (in_array('entertainment', $typesToInclude)) {
      $results = $results->merge($this->getExpenses(
        'entertainment',
        'entertainmentExpenses',
        $filters,
        fn($expense, $detail) => [
          '伝票番号' => $expense->id,
          '日付' => $expense->date,
          '種別' => '接待交際費',
          '明細内容' => $detail->content ?? '（内容未入力）',
          '金額' => $detail->amount,
        ]
      ));
    }

    if (in_array('business_trip', $typesToInclude)) {
      $results = $results->merge($this->getExpenses(
        'business_trip',
        'businessTripExpenses',
        $filters,
        fn($expense, $detail) => [
          '伝票番号' => $expense->id,
          '日付' => $expense->date,
          '種別' => '出張旅費',
          '明細内容' => $detail->description ?? '（内容未入力）',
          '金額' => $detail->amount,
        ]
      ));
    }

    return $results->sortBy('伝票番号')->values();
  }

  private function getExpenses(string $type, string $relation, array $filters, \Closure $mapFn)
  {
    $query = Expense::with($relation)->where('expense_type', $type);

    if (!empty($filters['date_from'])) {
      $query->whereDate('date', '>=', $filters['date_from']);
    }

    if (!empty($filters['date_to'])) {
      $query->whereDate('date', '<=', $filters['date_to']);
    }

    return $query->get()->flatMap(function ($expense) use ($relation, $mapFn) {
      return $expense->{$relation}->map(fn($detail) => $mapFn($expense, $detail));
    });
  }
}
