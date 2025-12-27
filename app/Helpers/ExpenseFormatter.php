<?php

namespace App\Helpers;

class ExpenseFormatter
{
  public static function format($value, ?string $type): string
  {
    return match ($type) {
      'yen' => number_format($value) . '円',
      'date' => ($value instanceof \Carbon\Carbon) ? $value->format('Y-m-d') : $value,
      'status' => expense_status_label($value),
      default => $value ?? '-',
    };
  }
}
