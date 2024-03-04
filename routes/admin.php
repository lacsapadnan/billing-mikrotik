<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLogController;
use App\Http\Controllers\Admin\AdminMikrotikImport;
use App\Http\Controllers\Admin\AdminNetworkController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminPrepaidController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::name('admin:')->group(function () {
    Route::middleware('guest:admin')
        ->group(function () {
            Route::get('login', [AdminAuthController::class, 'create'])->name('auth.login');
            Route::post('login', [AdminAuthController::class, 'store'])->name('auth.login');
        });
    Route::middleware('auth:admin')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::put('password', [PasswordController::class, 'update'])->name('password.update');
        Route::get('dashboard', AdminDashboardController::class)->name('dashboard');
        Route::get('logout', [AdminAuthController::class, 'destroy'])->name('auth.logout');

        //CUSTOMER#
        Route::resource('customer', AdminCustomerController::class);
        Route::get('customer/{customer}/deactivate', [AdminCustomerController::class, 'deactivate'])->name('customer.deactivate');

        //# PREPAID ##
        // recharge user
        Route::get('prepaid/user', [AdminPrepaidController::class, 'user'])->name('prepaid.user.index');
        Route::get('prepaid/user/add', [AdminPrepaidController::class, 'createUser'])->name('prepaid.user.create');
        Route::get('prepaid/user/{user}/recharge', [AdminPrepaidController::class, 'rechargeUser'])->name('prepaid.user.recharge');
        Route::get('prepaid/user/{user}/edit', [AdminPrepaidController::class, 'editUser'])->name('prepaid.user.edit');
        Route::delete('prepaid/user/{user}', [AdminPrepaidController::class, 'destroyUser'])->name('prepaid.user.destroy');
        Route::patch('prepaid/user/{user}', [AdminPrepaidController::class, 'updateUser'])->name('prepaid.user.update');
        Route::post('prepaid/user', [AdminPrepaidController::class, 'storeUser'])->name('prepaid.user.store');
        Route::get('prepaid/invoice/{invoice}/show', [AdminPrepaidController::class, 'showInvoice'])->name('prepaid.invoice.show');
        Route::get('prepaid/invoice/{invoice}/print', [AdminPrepaidController::class, 'printInvoice'])->name('prepaid.invoice.print');
        // voucher
        Route::get('prepaid/voucher', [AdminPrepaidController::class, 'voucher'])->name('prepaid.voucher.index');
        Route::get('prepaid/voucher/add', [AdminPrepaidController::class, 'createVoucher'])->name('prepaid.voucher.create');
        Route::get('prepaid/voucher/{voucher}/edit', [AdminPrepaidController::class, 'editVoucher'])->name('prepaid.voucher.edit');
        Route::delete('prepaid/voucher/{voucher}', [AdminPrepaidController::class, 'destroyVoucher'])->name('prepaid.voucher.destroy');
        Route::patch('prepaid/voucher/{voucher}', [AdminPrepaidController::class, 'updateVoucher'])->name('prepaid.voucher.update');
        Route::post('prepaid/voucher', [AdminPrepaidController::class, 'storeVoucher'])->name('prepaid.voucher.store');
        Route::get('prepaid/refill-account', [AdminPrepaidController::class, 'refillAccount'])->name('prepaid.refill-account');
        Route::post('prepaid/refill-account', [AdminPrepaidController::class, 'storeRefillAccount'])->name('prepaid.refill-account.store');

        Route::get('network/router', [AdminNetworkController::class, 'router'])->name('network.router.index');
        Route::get('network/router/add', [AdminNetworkController::class, 'createRouter'])->name('network.router.create');
        Route::get('network/router/{router}/edit', [AdminNetworkController::class, 'editRouter'])->name('network.router.edit');
        Route::delete('network/router/{router}', [AdminNetworkController::class, 'destroyRouter'])->name('network.router.destroy');
        Route::post('network/router', [AdminNetworkController::class, 'storeRouter'])->name('network.router.store');
        Route::patch('network/router/{router}', [AdminNetworkController::class, 'updateRouter'])->name('network.router.update');
        Route::get('network/pool', [AdminNetworkController::class, 'pool'])->name('network.pool.index');
        Route::get('network/pool/add', [AdminNetworkController::class, 'createPool'])->name('network.pool.create');
        Route::get('network/pool/{pool}/edit', [AdminNetworkController::class, 'editPool'])->name('network.pool.edit');
        Route::delete('network/pool/{pool}', [AdminNetworkController::class, 'destroyPool'])->name('network.pool.destroy');
        Route::post('network/pool', [AdminNetworkController::class, 'storePool'])->name('network.pool.store');
        Route::patch('network/pool/{pool}', [AdminNetworkController::class, 'updatePool'])->name('network.pool.update');
        Route::get('network/pool/option', [AdminNetworkController::class, 'poolOption'])->name('network.pool.option');
        Route::get('network/router/option', [AdminNetworkController::class, 'routerOption'])->name('network.router.option');
        Route::get('network/plan/option', [AdminNetworkController::class, 'planOption'])->name('network.plan.option');

        //# SERVICES ##
        Route::get('service/bandwidth', [AdminServiceController::class, 'bandwidth'])->name('service.bandwidth.index');
        Route::get('service/bandwidth/add', [AdminServiceController::class, 'createBandwidth'])->name('service.bandwidth.create');
        Route::get('service/bandwidth/{bandwidth}/edit', [AdminServiceController::class, 'editBandwidth'])->name('service.bandwidth.edit');
        Route::delete('service/bandwidth/{bandwidth}', [AdminServiceController::class, 'destroyBandwidth'])->name('service.bandwidth.destroy');
        Route::post('service/bandwidth', [AdminServiceController::class, 'storeBandwidth'])->name('service.bandwidth.store');
        Route::patch('service/bandwidth/{bandwidth}', [AdminServiceController::class, 'updateBandwidth'])->name('service.bandwidth.update');

        Route::get('service/hotspot', [AdminServiceController::class, 'hotspot'])->name('service.hotspot.index');
        Route::get('service/hotspot/add', [AdminServiceController::class, 'createHotspot'])->name('service.hotspot.create');
        Route::get('service/hotspot/{hotspot}/edit', [AdminServiceController::class, 'editHotspot'])->name('service.hotspot.edit');
        Route::delete('service/hotspot/{hotspot}', [AdminServiceController::class, 'destroyHotspot'])->name('service.hotspot.destroy');
        Route::post('service/hotspot', [AdminServiceController::class, 'storeHotspot'])->name('service.hotspot.store');
        Route::patch('service/hotspot/{hotspot}', [AdminServiceController::class, 'updateHotspot'])->name('service.hotspot.update');

        Route::get('service/pppoe', [AdminServiceController::class, 'pppoe'])->name('service.pppoe.index');
        Route::get('service/pppoe/add', [AdminServiceController::class, 'createPppoe'])->name('service.pppoe.create');
        Route::get('service/pppoe/{pppoe}/edit', [AdminServiceController::class, 'editPppoe'])->name('service.pppoe.edit');
        Route::delete('service/pppoe/{pppoe}', [AdminServiceController::class, 'destroyPppoe'])->name('service.pppoe.destroy');
        Route::post('service/pppoe', [AdminServiceController::class, 'storePppoe'])->name('service.pppoe.store');
        Route::patch('service/pppoe/{pppoe}', [AdminServiceController::class, 'updatePppoe'])->name('service.pppoe.update');

        // STATIC PAGES #
        Route::get('page/{title}', [AdminPageController::class, 'edit'])->name('page.edit');
        Route::put('page/{page}', [AdminPageController::class, 'update'])->name('page.update');
        // REPORT #
        Route::get('report/activation', [AdminReportController::class, 'reportActivation'])->name('report.activation');
        Route::get('report/daily', [AdminReportController::class, 'reportDaily'])->name('report.daily');
        Route::get('report/period', [AdminReportController::class, 'reportPeriod'])->name('report.period');

        // SETTING #
        Route::middleware('admin')->group(function () {
            Route::get('setting/xendit', [AdminSettingController::class, 'xendit'])->name('setting.xendit');
            Route::put('setting/xendit', [AdminSettingController::class, 'updateXendit'])->name('setting.xendit.update');
            Route::get('setting/general', [AdminSettingController::class, 'general'])->name('setting.general');
            Route::put('setting/general', [AdminSettingController::class, 'updateGeneral'])->name('setting.general.update');
            Route::get('setting/localisation', [AdminSettingController::class, 'localisation'])->name('setting.localisation');
            Route::put('setting/localisation', [AdminSettingController::class, 'updateLocalisation'])->name('setting.localisation.update');
            Route::get('setting/user', [AdminSettingController::class, 'listUser'])->name('setting.user.index');
            Route::get('setting/user/add', [AdminSettingController::class, 'createUser'])->name('setting.user.create');
            Route::post('setting/user', [AdminSettingController::class, 'storeUser'])->name('setting.user.store');
            Route::get('setting/user/{user}', [AdminSettingController::class, 'editUser'])->name('setting.user.edit');
            Route::patch('setting/user/{user}', [AdminSettingController::class, 'updateUser'])->name('setting.user.update');
            Route::delete('setting/user/{user}', [AdminSettingController::class, 'destroyUser'])->name('setting.user.destroy');
            Route::get('setting/import-mikrotik', [AdminMikrotikImport::class, 'create'])->name('setting.import-mikrotik.create');
            Route::post('setting/import-mikrotik', [AdminMikrotikImport::class, 'store'])->name('setting.import-mikrotik.store');
        });

        Route::get('log', [AdminLogController::class, 'index'])->name('log.index');
        Route::delete('log', [AdminLogController::class, 'clean'])->name('log.clean');
    });
    Route::redirect('/', '/admin/dashboard', 301);
});
