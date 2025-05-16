<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessTripController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EntertainmentController;
use App\Http\Controllers\SupplyController;

Route::get('/', function () {
    return view('welcome');
});

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

// 以下は未実装のルートに対するダミー
// Route::get('/expenses/business_trip', fn() => 'dummy business_trip')->name('business_trip.index');
Route::get('/expenses/business_trip/submit', fn() => 'dummy business_trip')->name('business_trip.submit');
Route::get('/expenses/transportation/submit', fn() => 'dummy transportation')->name('transportation.submit');
Route::get('/expenses/supply/submit', fn() => 'dummy transportation')->name('supplies.submit');
Route::get('/expenses/entertainment/submit', fn() => 'dummy entertainment')->name('entertainment.submit');



Route::get('/expenses/business_trip/apply', fn() => 'dummy business_trip')->name('business_trip.apply');
Route::get('/expenses/transportation/apply', fn() => 'dummy transportation')->name('transportation.apply');
Route::get('/expenses/supply/apply', fn() => 'dummy transportation')->name('supplies.apply');
Route::get('/expenses/entertainment/apply', fn() => 'dummy entertainment')->name('entertainment.apply');

// Route::get('/expenses/supplies', fn() => 'dummy supplies')->name('supplies.index');
// Route::get('/expenses/entertainment', fn() => 'dummy entertainment')->name('entertainment.index');
// Route::get('/expenses/transportation', fn() => 'dummy transportation')->name('transportation.index');
Route::get('/expenses', fn() => 'dummy expenses')->name('expenses.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
