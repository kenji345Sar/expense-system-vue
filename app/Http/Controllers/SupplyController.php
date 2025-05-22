<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supply;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\ExpenseListService;
use App\Helpers\ExpenseTypeRelationMap;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreSupplyRequest;
use App\Http\Requests\UpdateSupplyRequest;


class SupplyController extends BaseExpenseController
{
    protected string $expenseType = 'supplies';
    protected string $modelClass = Supply::class;
    protected string $routeName = 'supplies.index';


    public function create()
    {
        return $this->buildFormView(
            'supplies',
            '備品・消耗品費 新規作成フォーム',
            '備品・消耗品費申請',
            route('supplies.store'),
            route('supplies.index')
        );
    }

    public function store(StoreSupplyRequest $request)
    {
        $this->expenseService->store($request->all(), 'supplies', Supply::class);
        return redirect()->route('supplies.index')->with('success', '登録が完了しました！');
    }




    public function index(ExpenseListService $service)
    {
        $type = 'supplies'; // 申請種別を指定
        $expenses = $service->getExpenseList($type, auth()->user());
        $headers = config("expense_headers.$type");
        $relation = ExpenseTypeRelationMap::getRelationName($type);

        return view('expenses.index', compact('expenses', 'headers', 'type', 'relation'));
    }


    // 詳細表示
    public function show($supplies_expense)
    {
        return view('supplies.show', [
            'expense' => $supplies_expense,
        ]);
    }


    public function edit($id)
    {
        $expense = Expense::with('suppliesExpenses')->findOrFail($id);
        $details = $expense->suppliesExpenses->toArray();

        return $this->buildFormView(
            'supplies',
            '備品・消耗品費 編集フォーム',
            '備品・消耗品費申請',
            route('supplies.update', $id),
            route('supplies.index'),
            $details,
            true
        );
    }

    public function update(UpdateSupplyRequest $request, $id)
    {
        return parent::updateValidated($request->validated(), $id);
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
