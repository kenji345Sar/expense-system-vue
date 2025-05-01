<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\EntertainmentExpenseController;
use App\Http\Controllers\SuppliesExpenseController;
use App\Http\Controllers\BusinessTripExpenseController;

// 初期表示 → メニューにリダイレクト
Route::get('/', fn() => redirect()->route('expenses.index'));

// 経費メニュー画面
Route::get('/expenses', fn() => view('expenses.index'))->name('expenses.index');

// resourceルーティングで統一
Route::resource('business_trip_expenses', BusinessTripExpenseController::class);
Route::resource('supplies_expenses', SuppliesExpenseController::class);
Route::resource('entertainment_expenses', EntertainmentExpenseController::class);
Route::resource('transportation_expenses', TransportationController::class);
