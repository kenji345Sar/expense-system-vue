<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;


class ExpenseApprovalController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();

        if ($user?->is_admin) {
            $expenses = Expense::orderBy('date', 'desc')->get();
        } else {
            $expenses = Expense::where('user_id', $user->id)
                ->orderBy('date', 'desc')
                ->get();
        }

        return view('expenses.index', compact('expenses'));
    }

    public function approve($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->status = 'approved';
        $expense->approver_id = auth()->id();
        $expense->approved_at = now();
        $expense->save();

        return redirect()->route('approvals.index')->with('success', '承認しました');
    }

    public function return(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->status = 'returned';
        $expense->approval_comment = $request->input('comment');
        $expense->save();

        return redirect()->route('approvals.index')->with('info', '差戻しました');
    }
}
