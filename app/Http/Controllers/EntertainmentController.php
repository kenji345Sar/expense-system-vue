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
            'entertainment_date' => 'required|date',
            'client_name' => 'required|string',
            'place' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $entertainment = Entertainment::create(array_merge($validated, [
                'user_id' => 1, // ログイン未実装なら固定値
            ]));

            Expense::create([
                'user_id' => 1,
                'date' => $entertainment->entertainment_date,
                'amount' => $entertainment->amount,
                'description' => $entertainment->place,
                'expense_type' => 'entertainment',
            ]);
        });

        return redirect()
            ->route('entertainment.index')
            ->with('success', '登録が完了しました！');
    }

    // 一覧表示
    public function index()
    {

        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($user?->is_admin) {
            // 管理者：全ユーザのデータを取得
            $entertainment = Entertainment::with('user')->latest()->paginate(10);
        } else {
            // 一般ユーザ：自分のデータのみ
            $entertainment = Entertainment::where('user_id', auth()->id())->latest()->paginate(10);
        }

        return view('entertainment.index', compact('entertainment'));
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
        $entertainment_expense = Entertainment::findOrFail($id);
        return view('entertainment.edit', compact('entertainment_expense'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'entertainment_date' => 'required|date',
            'client_name' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'amount' => 'required|integer',
            'content' => 'nullable|string',
        ]);

        $item  = Entertainment::findOrFail($id);
        $item->update($validated);

        return redirect()->route('entertainment.index')
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
