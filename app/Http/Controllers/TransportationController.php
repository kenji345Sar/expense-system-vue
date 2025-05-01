<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\TransportationExpense;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    public function create()
    {
        return view('transportation.create');
    }



    // public function index()
    // {
    //     $transportation_expenses = TransportationExpense::all();
    //     return view('transportation.index', compact('transportation_expenses'));
    // }

    public function index()
    {
        $items = TransportationExpense::orderBy('use_date', 'desc')->get();
        return view('transportation.index', compact('items'));
    }


    public function show($id)
    {
        $item = TransportationExpense::findOrFail($id);
        return view('transportation.show', compact('item'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // バリデーション（簡易）
        $validated = $request->validate([
            'use_date' => 'required|date',
            'departure' => 'required|string',
            'arrival' => 'required|string',
            'route' => 'nullable|string',
            'amount' => 'required|numeric',
            'remarks' => 'nullable|string',
        ]);

        try {
            TransportationExpense::create($validated);
            Log::info('保存成功', $validated);
            return redirect()->route('transportation_expenses.index')->with('message', '申請を登録しました！');
        } catch (\Exception $e) {
            Log::error('保存エラー：' . $e->getMessage());
            return redirect('/transportation_expenses/create')->with('message', '保存に失敗しました');
        }
    }

    public function edit($id)
    {
        $item = TransportationExpense::findOrFail($id);
        return view('transportation_expenses.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'use_date' => 'required|date',
            'departure' => 'required|string',
            'arrival' => 'required|string',
            'route' => 'nullable|string',
            'amount' => 'required|numeric',
            'remarks' => 'nullable|string',
        ]);

        $item = TransportationExpense::findOrFail($id);
        $item->update($validated);

        return redirect()->route('transportation_expenses.show', $id)->with('message', '更新しました！');
    }

    public function destroy($id)
    {
        TransportationExpense::findOrFail($id)->delete();

        return redirect()->route('transportation_expenses.index')->with('message', '削除しました');
    }
}
