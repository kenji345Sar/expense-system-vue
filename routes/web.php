<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransportationExpenseController;
use App\Http\Controllers\EntertainmentExpenseController;
use App\Http\Controllers\SuppliesExpenseController;
use App\Http\Controllers\BusinessTripExpenseController;

// ▼ 最初にアクセスされたときは経費メニューにリダイレクト
Route::get('/', fn() => redirect()->route('expenses.index'));

// ▼ 経費メニュー表示（ログイン必須）
Route::middleware(['auth'])->group(function () {
    Route::get('/expenses', fn() => view('expenses.index'))->name('expenses.index');

    // resourceルーティング（各種経費申請）
    Route::resource('business_trip_expenses', BusinessTripExpenseController::class);
    Route::resource('supplies_expenses', SuppliesExpenseController::class);
    Route::resource('entertainment_expenses', EntertainmentExpenseController::class);
    Route::resource('transportation_expenses', TransportationExpenseController::class);

    // プロフィール関連（Breezeが作ったもの）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze認証（ログイン・登録・パスワードリセットなど）
require __DIR__ . '/auth.php';
