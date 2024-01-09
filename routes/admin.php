<?php

use App\Http\Controllers\Admin\AdminAuthController;
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
    });
    Route::redirect('/', '/admin/dashboard', 301);
});
