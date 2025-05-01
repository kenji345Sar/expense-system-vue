<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessTripExpense;


class BusinessTripExpenseController extends Controller
{
    //
    // 登録フォーム表示
    public function create()
    {
        return view('business_trip_expenses.create');
    }

    // データ保存
    public function store(Request $request)
    {

        $validated = $request->validate([
            'date' => 'required|date',
            'departure' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'transportation' => 'required|string|max:255',
            'amount' => 'required|integer',
            'remarks' => 'nullable|string',
        ]);



        BusinessTripExpense::create($validated);

        return redirect()->route('business_trip_expenses.index')->with('success', '登録が完了しました！');
    }

    // 一覧表示
    public function index()
    {
        $expenses = BusinessTripExpense::orderBy('date', 'desc')->get();
        return view('business_trip_expenses.index', compact('expenses'));
    }
    // 詳細表示
    public function show($id)
    {
        $expense = BusinessTripExpense::findOrFail($id);
        return view('business_trip_expenses.show', compact('expense'));
    }
    // 編集画面表示
    public function edit($id)
    {
        $expense = BusinessTripExpense::findOrFail($id);
        return view('business_trip_expenses.edit', compact('expense'));
    }
    // 更新処理
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'departure' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'purpose' => 'required|string|max:255', // ← 追加！
            'transportation' => 'required|string|max:255',
            'amount' => 'required|integer',
            'remarks' => 'nullable|string',
        ]);

        $expense = BusinessTripExpense::findOrFail($id);
        $expense->update($validated);

        return redirect()->route('business_trip_expenses.index')->with('success', '更新が完了しました！');
    }
    // 削除処理
    public function destroy($id)
    {
        $expense = BusinessTripExpense::findOrFail($id);
        $expense->delete();

        return redirect()->route('business_trip_expenses.index')->with('success', '削除が完了しました！');
    }
    // 交通手段の選択肢を取得  
    public function getTransportationOptions()
    {
        return [
            '電車',
            'バス',
            '飛行機',
            '自家用車',
            'タクシー',
            'その他',
        ];
    }
    // 宿泊の選択肢を取得
    public function getAccommodationOptions()
    {
        return [
            'あり',
            'なし',
        ];
    }
}
