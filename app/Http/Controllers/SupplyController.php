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
    //
    // フォーム表示
    // public function create()
    // {
    //     return view('supplies.create');
    // }

    // public function create()
    // {
    //     $details = []; // 空配列（新規用）

    //     // 一覧用設定からフォーム用フィールドをフィルター
    //     $allFields = config('expense_headers.supplies');
    //     $formFields = array_values(array_filter($allFields, function ($field) {
    //         return !in_array($field['key'], ['id', 'user.name']);
    //     }));

    //     return view('expenses.form', [
    //         'details' => $details,
    //         'pageTitle' => '備品・消耗品費 新規申請',
    //         'formTitle' => '備品消耗品',
    //         'formAction' => route('supplies.store'),
    //         'isEdit' => false,
    //         'fields' => $formFields,
    //         'backUrl' => route('supplies.index'),

    //     ]);
    // }

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


    // // データ保存
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'details' => 'required|array|min:1',
    //         'details.*.supply_date' => 'required|date',
    //         'details.*.item_name' => 'required|string|max:255',
    //         'details.*.quantity' => 'required|integer',
    //         'details.*.unit_price' => 'required|integer',
    //         'details.*.remarks' => 'nullable|string',
    //     ]);

    //     DB::transaction(function () use ($validated, $request) {
    //         $userId = auth()->id();
    //         $totalAmount = 0;

    //         // Expense（伝票ヘッダ）作成
    //         $expense = Expense::create([
    //             'user_id' => $userId,
    //             'date' => now(),
    //             'amount' => 0, // あとで更新
    //             'description' => '備品・消耗品費申請',
    //             'expense_type' => 'supplies',
    //             'status' => 'draft',
    //         ]);

    //         // SupplyExpenses（明細）を登録
    //         foreach ($request->input('details') as $index => $data) {
    //             Supply::create([
    //                 'user_id'     => $userId,
    //                 'expense_id'  => $expense->id,
    //                 'display_order' => $index,
    //                 'supply_date' => $data['supply_date'],
    //                 'item_name'   => $data['item_name'],
    //                 'quantity'    => $data['quantity'],
    //                 'unit_price'  => $data['unit_price'],
    //                 'total_price'  =>  $data['quantity'] * $data['unit_price'],
    //                 'remarks'     => $data['remarks'] ?? null,
    //             ]);

    //             // $totalAmount += $data['total_price'];
    //             $totalAmount += $data['quantity'] * $data['unit_price'];
    //         }

    //         // 合計金額を更新
    //         $expense->update([
    //             'amount' => $totalAmount,
    //         ]);
    //     });

    //     return redirect()
    //         ->route('supplies.index')
    //         ->with('success', '登録が完了しました！');
    // }


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

    // 編集画面表示
    // public function edit($supplies_expense)
    // {
    //     // 交通費申請の詳細を取得
    //     $supplies_expense = Expense::with('suppliesExpenses')->findOrFail($supplies_expense);

    //     return view('supplies.edit', compact('supplies_expense'));
    // }

    // public function edit($supplies_expense)
    // {
    //     // 一覧用設定からフォーム用フィールドをフィルター
    //     $allFields = config('expense_headers.supplies');
    //     $formFields = array_values(array_filter($allFields, function ($field) {
    //         return !in_array($field['key'], ['id', 'user.name']);
    //     }));
    //     $supplies_expense = Expense::with('suppliesExpenses')->findOrFail($supplies_expense);
    //     $details = $supplies_expense->suppliesExpenses->toArray(); // 編集用データ
    //     return view('expenses.form', [
    //         'details' => $details,
    //         'pageTitle' => '備品・消耗品費 編集フォーム',
    //         'formTitle' => '備品消耗品',
    //         'formAction' => route('supplies.update', $supplies_expense->id),
    //         'backUrl' => route('supplies.index'),
    //         'isEdit' => true,
    //         'fields' => $formFields,
    //     ]);
    // }

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
    // public function update(UpdateSupplyRequest $request, $id)
    // {
    //     $this->expenseService->update($request->validated(),  Supply::class, $id);
    //     return redirect()->route('supplies.index')->with('success', '更新が完了しました！');
    // }

    // 更新処理
    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'details' => 'required|array|min:1',
    //         'details.*.supply_date' => 'required|date',
    //         'details.*.item_name' => 'required|string|max:255',
    //         'details.*.quantity' => 'required|integer',
    //         'details.*.unit_price' => 'required|integer',
    //         'details.*.total_price' => 'required|integer',
    //         'details.*.remarks' => 'nullable|string',
    //     ]);
    //     DB::transaction(function () use ($validated, $id, $request) {

    //         // Expense を取得
    //         $expense = Expense::with('suppliesExpenses')->findOrFail($id);

    //         // 明細を一旦削除
    //         Supply::where('expense_id', $id)->delete();
    //         // 明細を再挿入
    //         foreach ($validated['details'] as $index => $row) {
    //             Supply::create([
    //                 'expense_id'         => $id,
    //                 'user_id'            => auth()->id(),
    //                 'display_order'      => $index,
    //                 'supply_date' => $row['supply_date'],
    //                 'item_name'   => $row['item_name'],
    //                 'quantity'    => $row['quantity'],
    //                 'unit_price'  => $row['unit_price'],
    //                 'total_price' => $row['total_price'],
    //                 'remarks'     => $row['remarks'] ?? null,
    //             ]);
    //         }

    //         // 合計金額と申請メモ（description）を更新
    //         $totalAmount = Supply::where('expense_id', $id)->sum('total_price');
    //         $expense->update([
    //             'amount'      => $totalAmount,
    //             'description' => $request->description,
    //         ]);
    //     });
    //     return redirect()
    //         ->route('supplies.index')
    //         ->with('success', '更新が完了しました！');
    // }

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
