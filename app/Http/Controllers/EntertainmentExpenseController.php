<?php

namespace App\Http\Controllers;

use App\Models\EntertainmentExpense;
use Illuminate\Http\Request;

class EntertainmentExpenseController extends Controller
{
    // フォーム表示
    public function create()
    {
        return view('entertainment_expenses.create');
    }

    // データ保存
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'client_name' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'amount' => 'required|integer',
            'content' => 'nullable|string',
        ]);

        EntertainmentExpense::create($validated);

        return redirect()->route('entertainment_expenses.create')->with('success', '登録が完了しました！');
    }

    // 一覧表示
    public function index()
    {
        $expenses = EntertainmentExpense::orderBy('date', 'desc')->get();
        return view('entertainment_expenses.index', compact('expenses'));
    }

}
