<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\TransportationExpense;
use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class TransportationExpenseController  extends Controller
{
    public function create()
    {
        return view('transportation_expenses.create');
    }


    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($user?->is_admin) {
            // 管理者は全てのデータを取得
            $items = TransportationExpense::orderBy('use_date', 'desc')->get();
        } else {
            // 一般ユーザーは自分のデータのみ取得
            $items = TransportationExpense::where('user_id', $user->id)->orderBy('use_date', 'desc')->get();
        }
        return view('transportation_expenses.index', compact('items'));
    }


    public function show($id)
    {
        $item = TransportationExpense::findOrFail($id);
        return view('transportation_expenses.show', compact('item'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'use_date' => 'required|date',
            'departure' => 'required|string',
            'arrival' => 'required|string',
            'route' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        DB::transaction(function () use ($validated) {
            $transport = TransportationExpense::create(array_merge($validated, [
                'user_id' => 1, // ← auth()->id()が使えるようになれば変更
            ]));

            Expense::create([
                'user_id' => 1,
                'date' => $transport->use_date,
                'amount' => $transport->amount,
                'description' => $transport->route,
                'expense_type' => 'transportation',
            ]);
        });

        return redirect()
            ->route('transportation_expenses.index')
            ->with('success', '登録が完了しました！');
    }

    public function edit($id)
    {
        $transportation_expense = TransportationExpense::findOrFail($id);
        return view('transportation_expenses.edit', compact('transportation_expense'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'use_date' => 'required|date',
            'departure' => 'required|string',
            'arrival' => 'required|string',
            'route' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        DB::transaction(function () use ($validated, $id) {
            $transport = TransportationExpense::findOrFail($id);
            $transport->update($validated);

            // 経費統合テーブルも更新（user_id, date, descriptionでマッチ）
            Expense::where([
                ['expense_type', 'transportation'],
                ['user_id', $transport->user_id],
                ['date', $transport->use_date],
                ['description', $transport->route],
            ])->latest()->first()?->update([
                'date' => $transport->use_date,
                'amount' => $transport->amount,
                'description' => $transport->route,
            ]);
        });

        return redirect()
            ->route('transportation_expenses.index')
            ->with('success', '更新が完了しました！');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $transport = TransportationExpense::findOrFail($id);

            // expenses 側も削除（descriptionやuse_dateでマッチ）
            Expense::where([
                ['expense_type', 'transportation'],
                ['user_id', $transport->user_id],
                ['date', $transport->use_date],
                ['description', $transport->route],
            ])->latest()->first()?->delete();

            // transportation_expenses も削除
            $transport->delete();
        });

        return redirect()
            ->route('transportation_expenses.index')
            ->with('success', '削除が完了しました！');
    }
}
