<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;

class ExpenseController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            $expenses = Expense::orderBy('date', 'desc')->get();
        } else {
            $expenses = Expense::where('user_id', $user->id)
                ->orderBy('date', 'desc')
                ->get();
        }

        return view('expenses.list', compact('expenses'));
    }
}
