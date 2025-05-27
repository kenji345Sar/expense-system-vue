<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense; // 追加: Expenseモデルをインポート
use App\Models\User; // 追加: Userモデルをインポート
use App\Services\ExpenseDetailExportService; // 追加: ExpenseDetailExportServiceをインポート
use Illuminate\Pagination\LengthAwarePaginator; // 追加: LengthAwarePaginatorをインポート
use Illuminate\Support\Facades\Response; // 追加: Responseファサードをインポート

class AllExpensesController extends Controller
{
    //
    public function index(Request $request, ExpenseDetailExportService $service)
    {
        $csvType  = $request->input('csv_type', 'summary');
        $sort = $request->input('sort', 'date');
        $direction = $request->input('direction', 'desc');


        // Controller 内で変換
        $displayToCode = [
            '交通費' => 'transportation',
            '備品・消耗品費' => 'supplies',
            '出張旅費' => 'business_trip',
            '接待交際費' => 'entertainment',
        ];

        $selectedTypes = $request->input('type', []);
        $expenseTypes = collect($selectedTypes)->map(function ($type) use ($displayToCode) {
            return $displayToCode[$type] ?? $type;
        })->all();


        $filters = [
            'type' => $expenseTypes, // 配列で取得
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
        ];

        if ($csvType  === 'detail') {
            // $details = $service->getUnifiedDetails($filters);
            $allDetails = $service->getUnifiedDetails($filters);
            $page = request()->get('page', 1);
            $perPage = 20;
            $items = $allDetails->slice(($page - 1) * $perPage, $perPage)->values();
            $details = new LengthAwarePaginator($items, $allDetails->count(), $perPage, $page, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);
            return view('expenses.all', [
                'csvType' => 'detail',
                'details' => $details,
            ]);
        } else {
            $query = Expense::with('user');

            // ▼ ここで検索条件を適用
            if (!empty($filters['type'])) {
                $query->whereIn('expense_type', $filters['type']);
            }
            if (!empty($filters['date_from'])) {
                $query->whereDate('date', '>=', $filters['date_from']);
            }
            if (!empty($filters['date_to'])) {
                $query->whereDate('date', '<=', $filters['date_to']);
            }

            $query->orderBy($sort, $direction);

            // $expenses = $query->orderBy('date', 'desc')->paginate(20);
            $expenses = $query->paginate(20);

            return view('expenses.all', [
                'csvType' => 'summary',
                'expenses' => $expenses,
            ]);
        }
    }


    public function showDetailList(ExpenseDetailExportService $service)
    {
        $details = $service->getUnifiedDetails();

        return view('expenses.detail-list', compact('details'));
    }

    public function export(Request $request, ExpenseDetailExportService $service)
    {
        $csvType = $request->input('csv_type', 'summary');

        $filters = [
            'type' => $request->input('type', []),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
        ];
  
        if ($csvType === 'detail') {
            $data = $service->getUnifiedDetails($filters);
        } else {
            $data = Expense::with('user')
                ->when($filters['type'], fn($q) => $q->whereIn('expense_type', $filters['type']))
                ->when($filters['date_from'], fn($q) => $q->whereDate('date', '>=', $filters['date_from']))
                ->when($filters['date_to'], fn($q) => $q->whereDate('date', '<=', $filters['date_to']))
                ->orderBy('date', 'desc')
                ->get()
                ->map(function ($expense) {
                    return [
                        '伝票番号' => $expense->id,
                        '日付' => $expense->date,
                        '種別' => $expense->expense_type,
                        '申請者' => optional($expense->user)->name,
                        '金額' => $expense->amount,
                    ];
                });
        }

        // CSV作成
        $csv = implode(",", array_keys($data->first() ?? [])) . "\n";
        foreach ($data as $row) {
            $csv .= implode(",", $row) . "\n";
        }

        $filename = 'expenses_export_' . now()->format('Ymd_His') . '.csv';

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ]);
    }
}
