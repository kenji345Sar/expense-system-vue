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
