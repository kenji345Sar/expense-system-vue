<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuppliesExpense;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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
        dd(request()->all());
        $validated = $request->validate([
            'date' => 'required|date',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'unit_price' => 'required|integer',
            'total_price' => 'required|integer',
            'remarks' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        DB::transaction(function () use ($validated) {
            // 元のテーブルに登録
            $supplies = SuppliesExpense::create($validated);

            // 統合expensesテーブルにも登録
            Expense::create([
                'user_id' => 1,
                'date' => $supplies->date,
                'amount' => $supplies->total_price, // 金額としてtotal_priceを使う
                'description' => $supplies->item_name,
                'expense_type' => 'supplies',
            ]);
        });

        return redirect()
            ->route('supplies_expenses.index')
            ->with('success', '登録が完了しました！');
    }

    // 一覧表示
    public function index()
    {
        // dd(request()->all());
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($user?->is_admin) {
            // 管理者：全ユーザのデータを取得
            $suppliesExpenses = SuppliesExpense::with('user')->latest()->paginate(10);
        } else {
            // 一般ユーザ：自分のデータのみ
            $suppliesExpenses = SuppliesExpense::where('user_id', auth()->id())->latest()->paginate(10);
        }

        return view('supplies_expenses.index', compact('suppliesExpenses'));
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
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'unit_price' => 'required|integer',
            'total_price' => 'required|integer',
            'remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $id) {
            $supplies = SuppliesExpense::findOrFail($id);
            $supplies->update($validated);

            // 対応する expense レコードを更新（expense_type: supplies）
            Expense::where([
                ['expense_type', 'supplies'],
                ['user_id', $supplies->user_id],
                ['date', $supplies->date],
                ['description', $supplies->item_name],
            ])->latest()->first()?->update([
                'date' => $supplies->date,
                'amount' => $supplies->total_price,
                'description' => $supplies->item_name,
            ]);
        });

        return redirect()
            ->route('supplies_expenses.index')
            ->with('success', '更新が完了しました！');
    }

    // 削除処理
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $supplies = SuppliesExpense::findOrFail($id);

            // 該当の expenses レコードを削除（expense_typeとマッチする）
            Expense::where([
                ['expense_type', 'supplies'],
                ['user_id', $supplies->user_id],
                ['date', $supplies->date],
                ['description', $supplies->item_name],
            ])->latest()->first()?->delete();

            $supplies->delete();
        });

        return redirect()
            ->route('supplies_expenses.index')
            ->with('success', '削除が完了しました！');
    }
}
