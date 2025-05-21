<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessTrip;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use App\Services\ExpenseListService;
use Illuminate\Support\Facades\Log;
use App\Helpers\ExpenseTypeRelationMap;

use App\Http\Requests\StoreBusinessTripRequest;
use App\Http\Requests\UpdateBusinessTripRequest;
use App\Services\ExpenseService;

class BusinessTripController extends BaseExpenseController
{

    protected string $expenseType = 'business_trip';
    protected string $modelClass = BusinessTrip::class;
    protected string $routeName = 'business_trip.index';
    //
    // 登録フォーム表示
    // public function create()
    // {
    //     return view('business_trip.create');
    // }

    // public function create()
    // {
    //     $details = []; // 空配列（新規用）

    //     // 一覧用設定からフォーム用フィールドをフィルター
    //     $allFields = config('expense_headers.business_trip');
    //     $formFields = array_values(array_filter($allFields, function ($field) {
    //         return !in_array($field['key'], ['id', 'user.name']);
    //     }));

    //     return view('expenses.form', [
    //         'details' => $details,
    //         'pageTitle' => '出張旅費 新規申請',
    //         'formTitle' => '出張旅費申請',
    //         'formAction' => route('business_trip.store'),
    //         'isEdit' => false,
    //         'fields' => $formFields,
    //         'backUrl' => route('business_trip.index'),

    //     ]);
    // }

    public function create()
    {
        return $this->buildFormView(
            'business_trip',
            '出張旅費 新規作成フォーム',
            '出張旅費申請',
            route('business_trip.store'),
            route('business_trip.index')
        );
    }

    //  php artisan make:request StoreEntertainmentRequest
    public function store(StoreBusinessTripRequest $request)
    {

        $this->expenseService->store($request->validated(), 'business_trip', BusinessTrip::class);
        return redirect()->route('business_trip.index')->with('success', '登録が完了しました！');
    }



    // データ保存
    // public function store(Request $request)
    // {

    //     $validated = $request->validate([
    //         'description' => 'nullable|string|max:1000',
    //         'details' => 'required|array',
    //         'details.*.business_trip_date' => 'required|date',
    //         'details.*.departure' => 'required|string|max:255',
    //         'details.*.destination' => 'required|string|max:255',
    //         'details.*.purpose' => 'nullable|string|max:255',
    //         'details.*.amount' => 'required|integer',
    //         'details.*.remarks' => 'nullable|string',
    //     ]);

    //     DB::transaction(function () use ($request, $validated) {
    //         $userId = auth()->id();
    //         $totalAmount = 0;
    //         // $descriptions = [];


    //         // ① Expenseを先に作る（明細を紐づけるための伝票ID）
    //         $expense = Expense::create([
    //             'user_id'      => $userId,
    //             'date'         => now(),
    //             'amount'       => 0,       // 後で更新
    //             'description'  => $request->description,      // 後で更新
    //             'expense_type' => 'business_trip',
    //             'status'       => 'draft',
    //         ]);

    //         // ② 明細を登録して紐づけ、合計金額も計算
    //         foreach ($request->input('details') as $index => $data) {
    //             BusinessTrip::create([
    //                 'user_id'       => $userId,
    //                 'expense_id'    => $expense->id,
    //                 'display_order' => $index,
    //                 'business_trip_date'      => $data['business_trip_date'],
    //                 'departure'     => $data['departure'],
    //                 'destination'       => $data['destination'],
    //                 'purpose'         => $data['purpose'],
    //                 'amount'        => $data['amount'],
    //                 'remarks'       => $data['remarks'] ?? null,
    //             ]);

    //             $totalAmount += $data['amount'];
    //         }

    //         // ③ Expense を更新（合計金額・概要）
    //         $expense->update([
    //             'amount'      => $totalAmount,
    //             'description' =>  $request->description,
    //         ]);
    //     });



    //     return redirect()->route('business_trip.index')->with('success', '登録が完了しました！');
    // }

    // 一覧表示

    // public function index()
    // {
    //     $user = auth()->user();

    //     if ($user?->is_admin) {
    //         // 管理者：全ユーザー分の交通費申請
    //         $business_trip_expenses = Expense::with('businessTripExpenses', 'user')
    //             ->where('expense_type', 'business_trip') // transportation固定
    //             ->orderBy('id', 'desc')
    //             ->get();
    //         // foreach ($business_trip_expenses as $expense) {
    //         //     echo 'Expense ID: ' . $expense->id . PHP_EOL;
    //         //     echo 'User Name: ' . $expense->user->name . PHP_EOL;
    //         //     echo 'Business Trip Count: ' . count($expense->businessTripExpenses) . PHP_EOL;
    //         // }
    //         // dd($business_trip_expenses->toArray());
    //     } else {
    //         // 一般ユーザ：自分の申請のみ
    //         $business_trip_expenses = Expense::with('businessTripExpenses')
    //             ->where('user_id', $user->id)
    //             ->where('expense_type', 'business_trip')
    //             ->orderBy('id', 'desc')
    //             ->get();
    //     }

    //     return view('business_trip.index', compact('business_trip_expenses'));
    // }

    public function index(ExpenseListService $service)
    {
        $type = 'business_trip';
        $expenses = $service->getExpenseList($type, auth()->user());
        $headers = config("expense_headers.$type");
        $relation = ExpenseTypeRelationMap::getRelationName($type);

        return view('expenses.index', compact('expenses', 'headers', 'type', 'relation'));
    }




    // 詳細表示
    public function show($id)
    {
        $business_trip_expenses = BusinessTrip::findOrFail($id);
        return view('business_trip.show', compact('business_trip_expenses'));
    }
    // 編集画面表示
    // public function edit($id)
    // {
    //     $business_trip = Expense::with('businessTripExpenses')->findOrFail($id);
    //     // dd($business_trip->toArray());
    //     return view('business_trip.edit', compact('business_trip'));
    // }

    // public function edit($id)
    // {

    //     // 一覧用設定からフォーム用フィールドをフィルター
    //     $allFields = config('expense_headers.business_trip');
    //     $formFields = array_values(array_filter($allFields, function ($field) {
    //         return !in_array($field['key'], ['id', 'user.name']);
    //     }));
    //     $business_trip_expense = Expense::with('businessTripExpenses')->findOrFail($id);
    //     $details = $business_trip_expense->businessTripExpenses->toArray(); // 編集用データ
    //     return view('expenses.form', [
    //         'details' => $details,
    //         'pageTitle' => '出張旅費 編集フォーム',
    //         'formTitle' => '出張旅費申請',
    //         'formAction' => route('business_trip.update', $id),
    //         'backUrl' => route('business_trip.index'),
    //         'isEdit' => true,
    //         'fields' => $formFields,
    //     ]);
    // }

    public function edit($id)
    {
        $expense = Expense::with('businessTripExpenses')->findOrFail($id);
        $details = $expense->businessTripExpenses->toArray();

        return $this->buildFormView(
            'business_trip',
            '出張旅費 編集フォーム',
            '出張旅費申請',
            route('business_trip.update', $id),
            route('business_trip.index'),
            $details,
            true
        );
    }

    public function update(UpdateBusinessTripRequest $request, $id)
    {
        return parent::updateValidated($request->validated(), $id);
    }


    // public function update(UpdateBusinessTripRequest $request, $id)
    // {
    //     $this->expenseService->update($request->validated(),  BusinessTrip::class, $id);
    //     return redirect()->route('business_trip.index')->with('success', '更新が完了しました！');
    // }


    // // 更新処理
    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'details' => 'required|array',
    //         'details.*.business_trip_date' => 'required|date',
    //         'details.*.departure' => 'required|string|max:255',
    //         'details.*.destination' => 'required|string|max:255',
    //         'details.*.purpose' => 'nullable|string|max:255',
    //         'details.*.amount' => 'required|integer',
    //         'details.*.remarks' => 'nullable|string',
    //     ]);
    //     DB::transaction(function () use ($validated, $id, $request) {

    //         // Expense を取得
    //         $expense = Expense::with('businessTripExpenses')->findOrFail($id);

    //         // 明細を一旦削除
    //         BusinessTrip::where('expense_id', $id)->delete();

    //         // 明細を再挿入
    //         foreach ($validated['details'] as $index => $row) {
    //             BusinessTrip::create([
    //                 'expense_id'         => $id,
    //                 'user_id'            => auth()->id(),
    //                 'display_order'      => $index,
    //                 'business_trip_date' => $row['business_trip_date'],
    //                 'departure'          => $row['departure'],
    //                 'destination'        => $row['destination'],
    //                 'purpose'            => $row['purpose'] ?? null,
    //                 'amount'             => $row['amount'],
    //                 'remarks'            => $row['remarks'] ?? null,
    //             ]);
    //         }

    //         // 合計金額と申請メモ（description）を更新
    //         $totalAmount = BusinessTrip::where('expense_id', $id)->sum('amount');
    //         $expense->update([
    //             'amount'      => $totalAmount,
    //             'description' => $request->description,
    //         ]);
    //     });

    //     return redirect()->route('business_trip.index')->with('success', '更新が完了しました！');
    // }
    // 削除処理
    public function destroy($id)
    {

        DB::transaction(function () use ($id) {
            $businessTrips = BusinessTripExpense::findOrFail($id);

            // 該当の expenses レコードを削除（expense_typeとマッチする）
            Expense::where([
                ['expense_type', 'business_trip'],
                ['user_id', $businessTrips->user_id],
                ['date', $businessTrips->date],
                ['description', $businessTrips->item_name],
            ])->latest()->first()?->delete();

            $businessTrips->delete();
        });


        return redirect()->route('business_trip.index')->with('success', '削除が完了しました！');
    }

    public function submit($id) {}

    public function approve($id)
    {
        // ここは後からでOK
        return redirect()->back()->with('success', '承認処理は未実装です');
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
