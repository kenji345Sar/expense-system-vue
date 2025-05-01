<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuppliesExpense;


class SuppliesExpenseController extends Controller
{
    //
    // フォーム表示
    public function create()
    {
        return view('supplies_expenses.create');
    }

    // データ保存
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'unit_price' => 'required|integer',
            'total_price' => 'required|integer',
            'remarks' => 'nullable|string',
        ]);

        SuppliesExpense::create($validated);

        return redirect()->route('supplies_expenses.create')->with('success', '登録が完了しました！');
    }

    // 一覧表示
    public function index()
    {
        $expenses = SuppliesExpense::orderBy('date', 'desc')->get();
        return view('supplies_expenses.index', compact('expenses'));
    }

    // 詳細表示
    public function show(SuppliesExpense $supplies_expense)
    {
        return view('supplies_expenses.show', [
            'expense' => $supplies_expense,
        ]);
    }

    // 編集画面表示
    public function edit(SuppliesExpense $supplies_expense)
    {
        return view('supplies_expenses.edit', compact('supplies_expense'));
    }

    // 更新処理
    public function update(Request $request, SuppliesExpense $supplies_expense)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'unit_price' => 'required|integer',
            'total_price' => 'required|integer',
            'remarks' => 'nullable|string',
        ]);

        $supplies_expense->update($validated);

        return redirect()->route('supplies_expenses.index')->with('success', '更新が完了しました！');
    }

    // 削除処理
    public function destroy(SuppliesExpense $supplies_expense)
    {
        $supplies_expense->delete();

        return redirect()->route('supplies_expenses.index')->with('success', '削除が完了しました！');
    }
}
