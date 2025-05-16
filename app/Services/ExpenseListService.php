<?php

namespace App\Services;

use App\Models\Expense;
use Illuminate\Support\Collection;

class ExpenseListService
{
  /**
   * 指定タイプのExpense一覧を取得（ユーザー種別考慮）
   *
   * @param string $type 'transportation', 'supplies', etc
   * @param \App\Models\User|null $user
   * @return Collection
   */
  public function getExpenseList(string $type, ?\App\Models\User $user): Collection
  {
    $query = Expense::with($this->getWithRelations($type));

    if (!$user?->is_admin) {
      $query->where('user_id', $user->id);
    }

    return $query->where('expense_type', $type)
      ->orderByDesc('id')
      ->get();
  }

  /**
   * expense_type に応じたリレーション名
   */
  private function getWithRelations(string $type): array
  {
    return match ($type) {
      'transportation' => ['transportationExpenses', 'user'],
      'supplies'       => ['suppliesExpenses', 'user'],
      'business_trip'  => ['businessTripExpenses', 'user'],
      'entertainment'  => ['entertainmentExpenses', 'user'],
      default          => ['user']
    };
  }
}
