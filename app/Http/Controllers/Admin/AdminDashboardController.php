<?php

namespace App\Http\Controllers\Admin;

use App\Enum\VoucherStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Log;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\UserRecharge;
use App\Support\Facades\Config;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $config = Config::all();
        $incomeToday = number_format(Transaction::whereDate('created_at', today())->sum('price'), 0, $config['dec_point'], $config['thousands_sep']);
        $incomeThisMonth = number_format(Transaction::whereMonth('created_at', now()->month)->sum('price'), 0, $config['dec_point'], $config['thousands_sep']);
        $totalUser = UserRecharge::count();
        $userActive = UserRecharge::whereStatus('on')->count().'/'.$totalUser;
        $totalCustomer = Customer::count();
        $plans = Plan::select('id', 'name')->withCount([
            'vouchers as unused_vouchers' => fn (Builder $query) => $query->whereStatus(VoucherStatus::UNUSED),
            'vouchers as used_vouchers' => fn (Builder $query) => $query->whereStatus(VoucherStatus::USED),
        ])->get();
        $expireds = UserRecharge::whereDate('expired_at', '<=', now())->get();
        $logs = Log::latest()->limit(10)->get();

        return view('admin.dashboard', compact('incomeToday', 'incomeThisMonth', 'userActive', 'totalCustomer', 'plans', 'expireds', 'config', 'logs'));
    }
}
