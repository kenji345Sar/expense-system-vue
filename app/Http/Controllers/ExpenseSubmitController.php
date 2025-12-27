<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Services\ExpenseService;


class ExpenseSubmitController extends Controller
{
    public function submit(Expense $expense, ExpenseService $expenseService)
    {
        $expenseService->submit($expense, auth()->user());

        return redirect()->route('expenses.all')
            ->with('success', '申請しました');
    }
}
