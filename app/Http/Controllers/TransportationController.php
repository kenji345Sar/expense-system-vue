<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Transportation;
use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use App\Services\ExpenseListService;
use App\Helpers\ExpenseTypeRelationMap;
use App\Http\Requests\StoreTransportationRequest;
use App\Http\Requests\UpdateTransportationRequest;
use App\Services\ExpenseService;

class TransportationController  extends BaseExpenseController
{
    protected string $expenseType = 'transportation';
    protected string $modelClass = Transportation::class;
    protected string $routeName = 'transportation.index';


    public function create()
    {
        return $this->buildFormView(
            'transportation',
            '交通費 新規作成フォーム',
            '交通費申請',
            route('transportation.store'),
            route('transportation.index')
        );
    }



    public function index(ExpenseListService $service)
    {
        $type = 'transportation';
        $expenses = $service->getExpenseList($type, auth()->user());
        $headers = config("expense_headers.$type");
        $relation = ExpenseTypeRelationMap::getRelationName($type);

        return view('expenses.index', compact('expenses', 'headers', 'type', 'relation'));
    }




    public function show($id)
    {
        $item = Transportation::findOrFail($id);
        return view('transportation.show', compact('item'));
    }


    public function store(StoreTransportationRequest $request)
    {

        $this->expenseService->store($request->validated(), 'transportation', Transportation::class);
        return redirect()->route('transportation.index')->with('success', '登録が完了しました！');
    }




    public function edit($id)
    {
        $expense = Expense::with('transportationExpenses')->findOrFail($id);
        $details = $expense->transportationExpenses->toArray();

        return $this->buildFormView(
            'transportation',
            '接待費 編集フォーム',
            '接待費申請',
            route('transportation.update', $id),
            route('transportation.index'),
            $details,
            true
        );
    }

    public function update(UpdateTransportationRequest $request, $id)
    {
        return parent::updateValidated($request->validated(), $id);
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
            ->route('transportation.index')
            ->with('success', '削除が完了しました！');
    }

    // app/Http/Controllers/TransportationExpenseController.php

    public function resubmit(Request $request, $id)
    {
        $transport = TransportationExpense::findOrFail($id);

        // 再申請可能な条件（本人＆差戻し状態）
        if ($transport->user_id !== auth()->id() || $transport->expense->status !== 'returned') {
            abort(403);
        }

        // 申請データをバリデーション＆更新
        $validated = $request->validate([
            'use_date' => 'required|date',
            'departure' => 'required|string',
            'arrival' => 'required|string',
            'route' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        DB::transaction(function () use ($transport, $validated) {
            $transport->update($validated);

            $expense = $transport->expense;
            $expense->update([
                'date' => $validated['use_date'],
                'amount' => $validated['amount'],
                'description' => $validated['route'],
                'status' => 'submitted',
                'approval_comment' => null,
                'approved_at' => null,
                'approver_id' => null,
            ]);
        });

        return redirect()->route('expenses.index')->with('success', '再申請が完了しました');
    }
}
