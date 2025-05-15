<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supply;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SupplyController extends Controller
{
    //
    // フォーム表示
    public function create()
    {
        return view('supplies.create');
    }

    // データ保存
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplies_expenses' => 'required|array|min:1',
            'supplies_expenses.*.supply_date' => 'required|date',
            'supplies_expenses.*.item_name' => 'required|string|max:255',
            'supplies_expenses.*.quantity' => 'required|integer',
            'supplies_expenses.*.unit_price' => 'required|integer',
            'supplies_expenses.*.total_price' => 'required|integer',
            'supplies_expenses.*.remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $userId = auth()->id();
            $totalAmount = 0;

            // Expense（伝票ヘッダ）作成
            $expense = Expense::create([
                'user_id' => $userId,
                'date' => now(),
                'amount' => 0, // あとで更新
                'description' => '備品・消耗品費申請',
                'expense_type' => 'supplies',
                'status' => 'draft',
            ]);

            // SupplyExpenses（明細）を登録
            foreach ($request->input('supplies_expenses') as $index => $data) {
                Supply::create([
                    'user_id'     => $userId,
                    'expense_id'  => $expense->id,
                    'display_order' => $index,
                    'supply_date' => $data['supply_date'],
                    'item_name'   => $data['item_name'],
                    'quantity'    => $data['quantity'],
                    'unit_price'  => $data['unit_price'],
                    'total_price' => $data['total_price'],
                    'remarks'     => $data['remarks'] ?? null,
                ]);

                $totalAmount += $data['total_price'];
            }

            // 合計金額を更新
            $expense->update([
                'amount' => $totalAmount,
            ]);
        });

        return redirect()
            ->route('supplies.index')
            ->with('success', '登録が完了しました！');
    }

    // 一覧表示
    public function index()
    {
        $user = auth()->user();

        if ($user?->is_admin) {
            // 管理者：全ユーザー分の交通費申請
            $supplies_expenses = Expense::with('supplyExpenses', 'user')
                ->where('expense_type', 'supplies') // transportation固定
                ->orderBy('id', 'desc')
                ->get();
        } else {
            // 一般ユーザ：自分の申請のみ
            $supplies_expenses = Expense::with('supplyExpenses')
                ->where('user_id', $user->id)
                ->where('expense_type', 'supplies')
                ->orderBy('id', 'desc')
                ->get();
        }
        return view('supplies.index', compact('supplies_expenses'));
    }


    // 詳細表示
    public function show($supplies_expense)
    {
        return view('supplies.show', [
            'expense' => $supplies_expense,
        ]);
    }

    // 編集画面表示
    public function edit($supplies_expense)
    {
        // 交通費申請の詳細を取得
        $supplies_expense = Expense::with('supplyExpenses')->findOrFail($supplies_expense);

        return view('supplies.edit', compact('supplies_expense'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'supplies_expenses' => 'required|array|min:1',
            'supplies_expenses.*.supply_date' => 'required|date',
            'supplies_expenses.*.item_name' => 'required|string|max:255',
            'supplies_expenses.*.quantity' => 'required|integer',
            'supplies_expenses.*.unit_price' => 'required|integer',
            'supplies_expenses.*.total_price' => 'required|integer',
            'supplies_expenses.*.remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $id, $request) {

            // Expense を取得
            $expense = Expense::with('supplyExpenses')->findOrFail($id);

            // 明細を一旦削除
            Supply::where('expense_id', $id)->delete();

            // 明細を再挿入
            foreach ($validated['supplies_expenses'] as $index => $row) {
                Supply::create([
                    'expense_id'         => $id,
                    'user_id'            => auth()->id(),
                    'display_order'      => $index,
                    'supply_date' => $row['supply_date'],
                    'item_name'   => $row['item_name'],
                    'quantity'    => $row['quantity'],
                    'unit_price'  => $row['unit_price'],
                    'total_price' => $row['total_price'],
                    'remarks'     => $row['remarks'] ?? null,
                ]);
            }

            // 合計金額と申請メモ（description）を更新
            $totalAmount = Supply::where('expense_id', $id)->sum('total_price');
            $expense->update([
                'amount'      => $totalAmount,
                'description' => $request->description,
            ]);
        });

        return redirect()
            ->route('supplies.index')
            ->with('success', '更新が完了しました！');
    }

    // 削除処理
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $supplies = Supply::findOrFail($id);

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
            ->route('supplies.index')
            ->with('success', '削除が完了しました！');
    }
}
