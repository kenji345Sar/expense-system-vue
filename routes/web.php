<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessTripController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EntertainmentController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\AllExpensesController;
use App\Http\Controllers\ExpenseApprovalController;
use App\Http\Controllers\ExpenseSubmitController;


Route::get('/', function () {
    return view('welcome');
});
Route::redirect('/expenses', '/expenses/menu');


Route::middleware(['auth'])->group(function () {
    Route::get('/expenses/menu', function () {
        return view('expenses.menu'); // view名は後で作成するファイルに合わせる
    })->name('expenses.menu');
    Route::resource('expenses/business_trip', BusinessTripController::class)
        ->names('business_trip');
    Route::resource('expenses/transportation', TransportationController::class)
        ->names('transportation');
    Route::resource('expenses/supply', SupplyController::class)
        ->names('supplies');
    Route::resource('expenses/entertainment', EntertainmentController::class)
        ->names('entertainment');
});

Route::get('/expenses/all', [AllExpensesController::class, 'index'])->name('expenses.all');
Route::get('/expenses/index', fn() => 'dummy expenses')->name('expenses.index');
// routes/web.php
Route::get('/expenses/export', [AllExpensesController::class, 'export'])->name('expenses.export');

// 承認機能
Route::middleware(['auth'])->prefix('approvals')->group(function () {
    Route::get('/', [ExpenseApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/{id}/approve', [ExpenseApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/{id}/return', [ExpenseApprovalController::class, 'return'])->name('approvals.return');

    // 申請（draft -> submitted）
    Route::post('/expenses/{expense}/submit', [ExpenseSubmitController::class, 'submit'])
        ->name('expenses.submit');
});


// 申請（draft -> submitted）※互換ルート：カテゴリ別 submit 名を維持
Route::middleware(['auth'])->group(function () {
    Route::post('/expenses/business_trip/{expense}/submit', [ExpenseSubmitController::class, 'submit'])
        ->name('business_trip.submit');

    Route::post('/expenses/transportation/{expense}/submit', [ExpenseSubmitController::class, 'submit'])
        ->name('transportation.submit');

    Route::post('/expenses/supply/{expense}/submit', [ExpenseSubmitController::class, 'submit'])
        ->name('supplies.submit');

    Route::post('/expenses/entertainment/{expense}/submit', [ExpenseSubmitController::class, 'submit'])
        ->name('entertainment.submit');
});



Route::get('/expenses/business_trip/apply', fn() => 'dummy business_trip')->name('business_trip.apply');
Route::get('/expenses/transportation/apply', fn() => 'dummy transportation')->name('transportation.apply');
Route::get('/expenses/supply/apply', fn() => 'dummy transportation')->name('supplies.apply');
Route::get('/expenses/entertainment/apply', fn() => 'dummy entertainment')->name('entertainment.apply');

// Route::get('/expenses/supplies', fn() => 'dummy supplies')->name('supplies.index');
// Route::get('/expenses/entertainment', fn() => 'dummy entertainment')->name('entertainment.index');
// Route::get('/expenses/transportation', fn() => 'dummy transportation')->name('transportation.index');
// Route::get('/expenses', fn() => 'dummy expenses')->name('expenses.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
