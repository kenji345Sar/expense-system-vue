<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\EntertainmentExpenseController;


Route::get('/', function () {
    return view('welcome');
});

// 一覧
Route::get('/transportation', [TransportationController::class, 'index'])->name('transportation.index');

// 新規作成・登録
Route::get('/transportation/create', [TransportationController::class, 'create']);
Route::post('/transportation/store', [TransportationController::class, 'store']);

// 編集・更新（※idより前に書く！）
Route::get('/transportation/{id}/edit', [TransportationController::class, 'edit'])->name('transportation.edit');
Route::put('/transportation/{id}', [TransportationController::class, 'update'])->name('transportation.update');

// 削除（同様に上に）
Route::delete('/transportation/{id}', [TransportationController::class, 'destroy'])->name('transportation.destroy');

// 詳細（最後に書く！）
Route::get('/transportation/{id}', [TransportationController::class, 'show'])->name('transportation.show');

// 接待交際費 新規作成フォーム表示
Route::get('/entertainment_expenses/create', [EntertainmentExpenseController::class, 'create'])
    ->name('entertainment_expenses.create');

// 接待交際費 登録処理
Route::post('/entertainment_expenses', [EntertainmentExpenseController::class, 'store'])
    ->name('entertainment_expenses.store');

    // 一覧表示
Route::get('/entertainment_expenses', [EntertainmentExpenseController::class, 'index'])
->name('entertainment_expenses.index');
