<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransportationExpenseController;
use App\Http\Controllers\EntertainmentExpenseController;
use App\Http\Controllers\SuppliesExpenseController;
use App\Http\Controllers\BusinessTripExpenseController;
use App\Http\Controllers\ExpenseApprovalController;
use App\Http\Controllers\ExpenseController;

// ▼ 最初にアクセスされたときは経費メニューにリダイレクト
Route::get('/', fn() => redirect()->route('expenses.menu'));

// ▼ 経費メニュー表示（ログイン必須）
Route::middleware(['auth'])->group(function () {
    // 経費メニュー表示
    Route::get('/expenses/menu', fn() => view('expenses.index'))->name('expenses.menu'); // ← メニュー画面を分離

    // 申請一覧（ユーザーごとのステータス付き）
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index'); // ← 本来の一覧

    // 承認処理
    Route::get('/approvals', [ExpenseApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approvals/{id}/approve', [ExpenseApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{id}/return', [ExpenseApprovalController::class, 'return'])->name('approvals.return');


    // resourceルーティング（各種経費申請）
    Route::resource('business_trip_expenses', BusinessTripExpenseController::class);
    Route::resource('supplies_expenses', SuppliesExpenseController::class);
    Route::resource('entertainment_expenses', EntertainmentExpenseController::class);
    Route::resource('transportation_expenses', TransportationExpenseController::class);

    // web.php
    Route::resource('expenses', ExpenseController::class);
    Route::post('expenses/{expense}/submit', [ExpenseController::class, 'submit'])->name('expenses.submit');


    Route::post('/transportation_expenses/{id}/resubmit', [TransportationExpenseController::class, 'resubmit'])
        ->name('transportation_expenses.resubmit');


    Route::post('/transportation_expenses/{id}/submit', [TransportationExpenseController::class, 'submit'])
        ->name('transportation_expenses.submit');

    // プロフィール関連（Breezeが作ったもの）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze認証（ログイン・登録・パスワードリセットなど）
require __DIR__ . '/auth.php';
