<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminNetworkController;
use App\Http\Controllers\Admin\AdminPrepaidController;
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
        Route::resource('customer', AdminCustomerController::class);

        Route::get('prepaid/user', [AdminPrepaidController::class, 'user'])->name('prepaid.user');

        Route::get('network/router', [AdminNetworkController::class, 'router'])->name('network.router.index');
        Route::get('network/router/add', [AdminNetworkController::class, 'createRouter'])->name('network.router.create');
        Route::get('network/router/{router}/edit', [AdminNetworkController::class, 'editRouter'])->name('network.router.edit');
        Route::delete('network/router/{router}', [AdminNetworkController::class, 'destroyRouter'])->name('network.router.destroy');
        Route::post('network/router', [AdminNetworkController::class, 'storeRouter'])->name('network.router.store');
        Route::patch('network/router/{router}', [AdminNetworkController::class, 'updateRouter'])->name('network.router.update');
    });
    Route::redirect('/', '/admin/dashboard', 301);
});
