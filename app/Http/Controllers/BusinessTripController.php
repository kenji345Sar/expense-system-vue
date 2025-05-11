<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessTrip;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class BusinessTripController extends Controller
{
    //
    // 登録フォーム表示
    public function create()
    {
        return view('business_trip.create');
    }

    // データ保存
    public function store(Request $request)
    {

        $validated = $request->validate([
            'description' => 'nullable|string|max:1000',
            'business_trip_expenses' => 'required|array',
            'business_trip_expenses.*.business_trip_date' => 'required|date',
            'business_trip_expenses.*.departure' => 'required|string|max:255',
            'business_trip_expenses.*.destination' => 'required|string|max:255',
            'business_trip_expenses.*.purpose' => 'nullable|string|max:255',
            'business_trip_expenses.*.amount' => 'required|integer',
            'business_trip_expenses.*.remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $userId = auth()->id();
            $totalAmount = 0;
            // $descriptions = [];


            // ① Expenseを先に作る（明細を紐づけるための伝票ID）
            $expense = Expense::create([
                'user_id'      => $userId,
                'date'         => now(),
                'amount'       => 0,       // 後で更新
                'description'  => $request->description,      // 後で更新
                'expense_type' => 'business_trip',
                'status'       => 'draft',
            ]);

            // ② 明細を登録して紐づけ、合計金額も計算
            foreach ($request->input('business_trip_expenses') as $index => $data) {
                BusinessTrip::create([
                    'user_id'       => $userId,
                    'expense_id'    => $expense->id,
                    'display_order' => $index,
                    'business_trip_date'      => $data['business_trip_date'],
                    'departure'     => $data['departure'],
                    'destination'       => $data['destination'],
                    'purpose'         => $data['purpose'],
                    'amount'        => $data['amount'],
                    'remarks'       => $data['remarks'] ?? null,
                ]);

                $totalAmount += $data['amount'];
            }

            // ③ Expense を更新（合計金額・概要）
            $expense->update([
                'amount'      => $totalAmount,
                'description' =>  $request->description,
            ]);
        });



        return redirect()->route('business_trip.index')->with('success', '登録が完了しました！');
    }

    // 一覧表示

    public function index()
    {
        $user = auth()->user();

        if ($user?->is_admin) {
            // 管理者：全ユーザー分の交通費申請
            $business_trip_expenses = Expense::with('businessTripExpenses', 'user')
                ->where('expense_type', 'business_trip') // transportation固定
                ->orderBy('id', 'desc')
                ->get();
            // foreach ($business_trip_expenses as $expense) {
            //     echo 'Expense ID: ' . $expense->id . PHP_EOL;
            //     echo 'User Name: ' . $expense->user->name . PHP_EOL;
            //     echo 'Business Trip Count: ' . count($expense->businessTripExpenses) . PHP_EOL;
            // }
            // dd($business_trip_expenses->toArray());
        } else {
            // 一般ユーザ：自分の申請のみ
            $business_trip_expenses = Expense::with('businessTripExpenses')
                ->where('user_id', $user->id)
                ->where('expense_type', 'business_trip')
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('business_trip.index', compact('business_trip_expenses'));
    }

    // 詳細表示
    public function show($id)
    {
        $business_trip_expenses = BusinessTrip::findOrFail($id);
        return view('business_trip.show', compact('business_trip_expenses'));
    }
    // 編集画面表示
    public function edit($id)
    {
        $business_trip = Expense::with('businessTripExpenses')->findOrFail($id);
        // dd($business_trip->toArray());
        return view('business_trip.edit', compact('business_trip'));
    }
    // 更新処理
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'business_trip_expenses' => 'required|array',
            'business_trip_expenses.*.business_trip_date' => 'required|date',
            'business_trip_expenses.*.departure' => 'required|string|max:255',
            'business_trip_expenses.*.destination' => 'required|string|max:255',
            'business_trip_expenses.*.purpose' => 'nullable|string|max:255',
            'business_trip_expenses.*.amount' => 'required|integer',
            'business_trip_expenses.*.remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $id, $request) {

            // Expense を取得
            $expense = Expense::with('businessTripExpenses')->findOrFail($id);

            // 明細を一旦削除
            BusinessTrip::where('expense_id', $id)->delete();

            // 明細を再挿入
            foreach ($validated['business_trip_expenses'] as $index => $row) {
                BusinessTrip::create([
                    'expense_id'         => $id,
                    'user_id'            => auth()->id(),
                    'display_order'      => $index,
                    'business_trip_date' => $row['business_trip_date'],
                    'departure'          => $row['departure'],
                    'destination'        => $row['destination'],
                    'purpose'            => $row['purpose'] ?? null,
                    'amount'             => $row['amount'],
                    'remarks'            => $row['remarks'] ?? null,
                ]);
            }

            // 合計金額と申請メモ（description）を更新
            $totalAmount = BusinessTrip::where('expense_id', $id)->sum('amount');
            $expense->update([
                'amount'      => $totalAmount,
                'description' => $request->description,
            ]);
        });

        return redirect()->route('business_trip.index')->with('success', '更新が完了しました！');
    }
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
