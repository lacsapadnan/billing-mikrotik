<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCustomerController;
use Illuminate\Support\Facades\Route;

Route::name('admin:')->group(function () {
    Route::middleware('guest:admin')
        ->group(function () {
            Route::get('login', [AdminAuthController::class, 'create'])->name('auth.login');
            Route::post('login', [AdminAuthController::class, 'store'])->name('auth.login');
        });
    Route::middleware('auth:admin')->group(function () {
        Route::view('dashboard', 'admin.dashboard')->name('dashboard');
        Route::get('logout', [AdminAuthController::class, 'destroy'])->name('auth.logout');
        Route::prefix('customer')->name('customer.')->group(function(){
            Route::get('/', [AdminCustomerController::class, 'index'])->name('list');
            Route::get('/{customer}/detail', [AdminCustomerController::class, 'show'])->name('detail');
            Route::get('/{customer}/delete', [AdminCustomerController::class, 'destroy'])->name('delete');
            Route::get('/add', [AdminCustomerController::class, 'create'])->name('add');
            Route::get('/{customer}/edit', [AdminCustomerController::class, 'edit'])->name('edit');
            Route::post('/', [AdminCustomerController::class, 'store'])->name('store');
            Route::post('/{customer}', [AdminCustomerController::class, 'update'])->name('update');
        });
    });
    Route::redirect('/', '/admin/dashboard', 301);
});
