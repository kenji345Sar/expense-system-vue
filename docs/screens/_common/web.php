<?php
// Breeze認証（自動生成）
Auth::routes();

// メニュー画面
Route::get('/expenses/menu', [ExpenseController::class, 'menu'])->middleware(['auth'])->name('expenses.menu');

// 一覧画面（カテゴリ別）
Route::get('/expenses/{type}', [ExpenseController::class, 'index'])->middleware(['auth'])->name('expenses.index');

// 新規作成
Route::get('/expenses/{type}/create', [ExpenseController::class, 'create'])->middleware(['auth'])->name('expenses.create');
Route::post('/expenses/{type}', [ExpenseController::class, 'store'])->middleware(['auth'])->name('expenses.store');

// 編集画面
Route::get('/expenses/{type}/{id}/edit', [ExpenseController::class, 'edit'])->middleware(['auth'])->name('expenses.edit');
Route::put('/expenses/{type}/{id}', [ExpenseController::class, 'update'])->middleware(['auth'])->name('expenses.update');

// 申請処理（一覧画面からPOST）
Route::post('/expenses/{type}/{id}/submit', [ExpenseController::class, 'submit'])->middleware(['auth'])->name('expenses.submit');

// 削除（任意）
Route::delete('/expenses/{type}/{id}', [ExpenseController::class, 'destroy'])->middleware(['auth'])->name('expenses.destroy');

// CSV出力（申請済・承認済のみ）
Route::get('/expenses/{type}/export', [ExpenseController::class, 'exportCsv'])->middleware(['auth'])->name('expenses.export');
