<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerVoucherController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::middleware('auth')->group(function () {

    Route::name('customer:')->prefix('customer')->group(function () {
        Route::view('/dashboard', 'customer.dashboard')->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::put('password', [PasswordController::class, 'update'])->name('password.update');
        Route::get('/voucher', [CustomerVoucherController::class, 'voucher'])->name('voucher.create');
        Route::post('/voucher/activate', [CustomerVoucherController::class, 'voucherActivate'])->name('voucher.activate');
        Route::get('/history/voucher', [CustomerVoucherController::class, 'voucherHistory'])->name('history.voucher');

        // ORDER #
        Route::get('order', [CustomerOrderController::class, 'index'])->name('order.index');
        Route::get('order/{plan}', [CustomerOrderController::class, 'buy'])->name('order.buy');
        Route::get('order/{order}/detail', [CustomerOrderController::class, 'detail'])->name('order.detail');
        Route::get('order/{order}/check', [CustomerOrderController::class, 'check'])->name('order.check');
        Route::get('order/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('order.cancel');
        Route::get('/history/order', [CustomerOrderController::class, 'history'])->name('history.order');
    });
});

require __DIR__.'/auth.php';
