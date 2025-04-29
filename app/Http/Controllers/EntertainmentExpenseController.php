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

        return redirect()->route('entertainment_expenses.index')->with('success', '登録が完了しました！');
    }

    // 一覧表示
    public function index()
    {
        $expenses = EntertainmentExpense::orderBy('date', 'desc')->get();
        return view('entertainment_expenses.index', compact('expenses'));
    }

    // 詳細表示
    public function show($id)
    {
        $expense = EntertainmentExpense::findOrFail($id);
        return view('entertainment_expenses.show', compact('expense'));
    }

    // 編集画面表示
    public function edit($id)
    {
        $expense = EntertainmentExpense::findOrFail($id);
        return view('entertainment_expenses.edit', compact('expense'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'client_name' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'amount' => 'required|integer',
            'content' => 'nullable|string',
        ]);

        $expense = EntertainmentExpense::findOrFail($id);
        $expense->update($validated);

        return redirect()->route('entertainment_expenses.index')
            ->with('success', '更新が完了しました！');
    }
    // 削除処理
    public function destroy($id)
    {
        $expense = EntertainmentExpense::findOrFail($id);
        $expense->delete();

        return redirect()->route('entertainment_expenses.index')
            ->with('success', '削除が完了しました！');
    }
}
