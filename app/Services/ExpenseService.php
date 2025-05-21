<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Expense;

class ExpenseService
{
  public function store(array $validated, string $expenseType, string $modelClass): Expense
  {
    return DB::transaction(function () use ($validated, $expenseType, $modelClass) {
      $userId = auth()->id();
      $expense = Expense::create([
        'user_id'      => $userId,
        'date'         => now(),
        'amount'       => 0,
        'description'  => '',
        'expense_type' => $expenseType,
        'status'       => 'draft',
      ]);

      $totalAmount = 0;
      foreach ($validated['details'] as $index => $data) {
        // 特殊対応：supplies モジュールだけ 'total_price' → 'amount'
        if ($expenseType === 'supplies' && isset($data['total_price'])) {
          $data['amount'] = $data['total_price'];
        }

        $modelClass::create(array_merge($data, [
          'user_id'       => $userId,
          'expense_id'    => $expense->id,
          'display_order' => $index,
        ]));
        $totalAmount += $data['amount'];
      }

      $expense->update([
        'amount' => $totalAmount,
        'description' => $validated['description'] ?? '',
      ]);

      return $expense;
    });
  }

  public function update(array $validated, string $expenseType, string $modelClass, int $id): Expense
  {
    return DB::transaction(function () use ($validated, $expenseType, $modelClass, $id) {
      $userId = auth()->id();
      $expense = Expense::findOrFail($id);

      $modelClass::where('expense_id', $id)->delete();

      foreach ($validated['details'] as $index => $data) {

        // 特殊対応：supplies モジュールだけ 'total_price' → 'amount'
        if ($expenseType === 'supplies' && isset($data['total_price'])) {
          $data['amount'] = $data['total_price'];
        }

        $modelClass::create(array_merge($data, [
          'user_id'       => $userId,
          'expense_id'    => $id,
          'display_order' => $index,
        ]));
      }

      $amountColumn = $expenseType === 'supplies' ? 'total_price' : 'amount';

      $totalAmount = $modelClass::where('expense_id', $id)->sum($amountColumn);

      $expense->update([
        'amount' => $totalAmount,
        'description' => $validated['description'] ?? '',
      ]);

      return $expense;
    });
  }
}
