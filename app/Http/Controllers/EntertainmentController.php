<?php

namespace App\Http\Controllers;

use App\Models\Entertainment;
use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use App\Services\ExpenseListService;
use App\Helpers\ExpenseTypeRelationMap;
use App\Http\Requests\StoreEntertainmentRequest;
use App\Http\Requests\UpdateEntertainmentRequest;
use App\Services\ExpenseService;

class EntertainmentController extends BaseExpenseController
{

    protected string $expenseType = 'entertainment';
    protected string $modelClass = Entertainment::class;
    protected string $routeName = 'entertainment.index';

    public function create()
    {
        return $this->buildFormView(
            'entertainment',
            '接待費 新規作成フォーム',
            '接待費申請',
            route('entertainment.store'),
            route('entertainment.index')
        );
    }


    public function store(StoreEntertainmentRequest $request)
    {

        $this->expenseService->store($request->validated(), 'entertainment', Entertainment::class);
        return redirect()->route('entertainment.index')->with('success', '登録が完了しました！');
    }


    public function index(ExpenseListService $service)
    {
        $type = 'entertainment'; // 申請種別
        $expenses = $service->getExpenseList($type, auth()->user());
        $headers = config("expense_headers.$type");
        $relation = ExpenseTypeRelationMap::getRelationName($type);

        return view('expenses.index', compact('expenses', 'headers', 'type', 'relation'));
    }

    // 詳細表示
    public function show($id)
    {
        $expense = Entertainment::findOrFail($id);
        return view('entertainment.show', compact('expense'));
    }



    public function edit($id)
    {
        $expense = Expense::with('entertainmentExpenses')->findOrFail($id);
        $details = $expense->entertainmentExpenses->toArray();

        return $this->buildFormView(
            'entertainment',
            '接待費 編集フォーム',
            '接待費申請',
            route('entertainment.update', $id),
            route('entertainment.index'),
            $details,
            true
        );
    }

    public function update(UpdateEntertainmentRequest $request, $id)
    {
        return parent::updateValidated($request->validated(), $id);
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
