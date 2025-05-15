<?php

namespace App\Http\Controllers;

use App\Models\Entertainment;
use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class EntertainmentController extends Controller
{
    // フォーム表示
    public function create()
    {
        return view('entertainment.create');
    }

    // データ保存
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:255',
            'entertainment_expenses' => 'required|array|min:1',
            'entertainment_expenses.*.entertainment_date' => 'required|date',
            'entertainment_expenses.*.client_name' => 'required|string|max:100',
            'entertainment_expenses.*.place' => 'required|string|max:100',
            'entertainment_expenses.*.content' => 'nullable|string|max:255',
            'entertainment_expenses.*.amount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $userId = auth()->id();
            $totalAmount = 0;

            // ① Expenseを先に作る（明細を紐づけるための伝票ID）
            $expense = Expense::create([
                'user_id'      => $userId,
                'date'         => now(),
                'amount'       => 0,       // 後で更新
                'description'  => '',      // 後で更新
                'expense_type' => 'entertainment',
                'status'       => 'draft',
            ]);
            // ② 明細を登録して紐づけ、合計金額も計算
            foreach ($request->input('entertainment_expenses') as $index => $data) {
                Entertainment::create([
                    'user_id'       => $userId,
                    'expense_id'    => $expense->id,
                    'display_order' => $index,
                    'entertainment_date'      => $data['entertainment_date'],
                    'client_name'     => $data['client_name'],
                    'place'       => $data['place'],
                    'content'         => $data['content'],
                    'amount'        => $data['amount'],
                ]);

                $totalAmount += $data['amount'];
            }

            // ③ Expense を更新（合計金額・概要）
            $expense->update([
                'amount'      => $totalAmount,
                'description' => $request->description,
            ]);
        });

        return redirect()
            ->route('entertainment.index')
            ->with('success', '登録が完了しました！');
    }

    // 一覧表示
    public function index()
    {

        $user = auth()->user();

        if ($user?->is_admin) {
            // 管理者：全ユーザー分の交通費申請
            $entertainment_expenses = Expense::with('entertainmentExpenses', 'user')
                ->where('expense_type', 'entertainment') // transportation固定
                ->orderBy('id', 'desc')
                ->get();
        } else {
            // 一般ユーザ：自分の申請のみ
            $entertainment_expenses = Expense::with('entertainmentExpenses')
                ->where('user_id', $user->id)
                ->where('expense_type', 'entertainment')
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('entertainment.index', compact('entertainment_expenses'));
    }

    // 詳細表示
    public function show($id)
    {
        $expense = Entertainment::findOrFail($id);
        return view('entertainment.show', compact('expense'));
    }

    // 編集画面表示
    public function edit($id)
    {

        $entertainment = Expense::with('entertainmentExpenses')->findOrFail($id);
        return view('entertainment.edit', compact('entertainment'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:255',
            'entertainment_expenses' => 'required|array|min:1',
            'entertainment_expenses.*.entertainment_date' => 'required|date',
            'entertainment_expenses.*.client_name' => 'required|string|max:100',
            'entertainment_expenses.*.place' => 'required|string|max:100',
            'entertainment_expenses.*.content' => 'nullable|string|max:255',
            'entertainment_expenses.*.amount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $id, $request) {

            // Expense を取得
            $expense = Expense::with('entertainmentExpenses')->findOrFail($id);

            // 明細を一旦削除
            Entertainment::where('expense_id', $id)->delete();

            // 明細を再挿入
            foreach ($validated['entertainment_expenses'] as $index => $row) {
                Entertainment::create([
                    'expense_id'         => $id,
                    'user_id'            => auth()->id(),
                    'display_order'      => $index,
                    'entertainment_date' => $row['entertainment_date'],
                    'client_name'          => $row['client_name'],
                    'place'        => $row['place'],
                    'content'            => $row['content'],
                    'amount'             => $row['amount'],

                ]);
            }

            // 合計金額と申請メモ（description）を更新
            $totalAmount = Entertainment::where('expense_id', $id)->sum('amount');
            $expense->update([
                'amount'      => $totalAmount,
                'description' => $request->description,
            ]);
        });

        return redirect()
            ->route('transportation.index')
            ->with('success', '更新が完了しました！');
    }
    // 削除処理
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $entertainment = Entertainment::findOrFail($id);

            // expenses テーブル側も削除
            Expense::where('user_id', $entertainment->user_id)
                ->where('date', $entertainment->entertainment_date)
                ->where('amount', $entertainment->amount)
                ->where('description', $entertainment->place) // 登録時のdescriptionが place だった場合
                ->where('expense_type', 'entertainment')
                ->delete();

            $entertainment->delete();
        });

        return redirect()->route('entertainment.index')
            ->with('success', '削除が完了しました！');
    }
}
