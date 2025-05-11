<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessTripController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\EntertainmentController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\ExpenseApprovalController;
use App\Http\Controllers\ExpenseController;

// ▼ 最初にアクセスされたときは経費メニューにリダイレクト
Route::get('/', fn() => redirect()->route('expenses.menu'));

// ▼ 経費メニュー表示（ログイン必須）
Route::middleware(['auth'])->group(function () {
    // 経費メニュー表示
    Route::get('/expenses/menu', fn() => view('expenses.menu'))->name('expenses.menu'); // ← メニュー画面を分離

    // 申請一覧（ユーザーごとのステータス付き）
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index'); // ← 本来の一覧

    Route::prefix('expenses/business_trip')->middleware(['auth'])->group(function () {
        Route::get('/', [BusinessTripController::class, 'index'])->name('business_trip.index');
        Route::get('create', [BusinessTripController::class, 'create'])->name('business_trip.create');
        Route::get('{id}', [BusinessTripController::class, 'show'])->name('business_trip.show');
        Route::get('{id}/edit', [BusinessTripController::class, 'edit'])->name('business_trip.edit');
        Route::post('/', [BusinessTripController::class, 'store'])->name('business_trip.store');
        Route::put('{id}', [BusinessTripController::class, 'update'])->name('business_trip.update');
        // Route::put('expenses/business_trip/{id}', function ($id) {
        //     return '更新成功: ID = ' . $id;
        // })->name('business_trip.update');
        Route::delete('{id}', [BusinessTripController::class, 'destroy'])->name('business_trip.destroy');
        Route::post('{id}/submit', [BusinessTripController::class, 'submit'])->name('business_trip.submit');
    });

    Route::prefix('expenses/transportation')->middleware(['auth'])->group(function () {
        Route::get('/', [TransportationController::class, 'index'])->name('transportation.index');
        Route::get('create', [TransportationController::class, 'create'])->name('transportation.create');
        Route::get('{id}', [TransportationController::class, 'show'])->name('transportation.show');
        Route::get('{id}/edit', [TransportationController::class, 'edit'])->name('transportation.edit');
        Route::post('/', [TransportationController::class, 'store'])->name('transportation.store');
        Route::put('{id}', [TransportationController::class, 'update'])->name('transportation.update');
        Route::delete('{id}', [TransportationController::class, 'destroy'])->name('transportation.destroy');
        Route::post('{id}/submit', [TransportationController::class, 'submit'])->name('transportation.submit');
    });

    Route::prefix('expenses/supply')->middleware(['auth'])->group(function () {
        Route::get('/', [SupplyController::class, 'index'])->name('supplies.index');
        Route::get('create', [SupplyController::class, 'create'])->name('supplies.create');
        Route::get('{id}', [SupplyController::class, 'show'])->name('supplies.show');
        Route::get('{id}/edit', [SupplyController::class, 'edit'])->name('supplies.edit');
        Route::post('/', [SupplyController::class, 'store'])->name('supplies.store');
        Route::put('{id}', [SupplyController::class, 'update'])->name('supplies.update');
        Route::delete('{id}', [SupplyController::class, 'destroy'])->name('supplies.destroy');
        Route::post('{id}/submit', [SupplyController::class, 'submit'])->name('supplies.submit');
    });



    // 承認処理
    Route::get('/approvals', [ExpenseApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approvals/{id}/approve', [ExpenseApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{id}/return', [ExpenseApprovalController::class, 'return'])->name('approvals.return');


    // resourceルーティング（各種経費申請）
    // Route::resource('business_trip', BusinessTripController::class);
    // Route::resource('supplies', SuppliesController::class);
    Route::resource('entertainment', EntertainmentController::class);
    // Route::resource('transportation', TransportationController::class);

    // web.php
    Route::resource('expenses', ExpenseController::class);
    Route::post('expenses/{expense}/submit', [ExpenseController::class, 'submit'])->name('expenses.submit');


    // Route::post('/transportation_expenses/{id}/resubmit', [TransportationExpenseController::class, 'resubmit'])
    //     ->name('transportation_expenses.resubmit');


    // Route::post('/transportation_expenses/{id}/submit', [TransportationExpenseController::class, 'submit'])
    //     ->name('transportation_expenses.submit');

    // プロフィール関連（Breezeが作ったもの）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze認証（ログイン・登録・パスワードリセットなど）
require __DIR__ . '/auth.php';
