<?php

namespace App\Http\Controllers\Customer;

use App\DataTables\CustomerVoucherHistoryDataTable;
use App\Enum\RechargeGateway;
use App\Enum\VoucherStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Voucher;
use App\Support\Package;
use Illuminate\Http\Request;

class CustomerVoucherController extends Controller
{
    public function voucher()
    {
        return view('customer.voucher.form');
    }

    public function voucherActivate(Request $request)
    {
        $validated = $request->validate([
            'voucher_code' => ['required', 'string'],
        ]);
        /** @var Voucher $voucher */
        $voucher = Voucher::where('code', $validated['voucher_code'])->where('status', VoucherStatus::UNUSED)->first();
        if (! $voucher) {
            return redirect()->back()->with('error', 'Voucher not valid');
        }
        $customer = Customer::find(auth()->user()->id);
        Package::rechargeUser($customer, $voucher->router, $voucher->plan, RechargeGateway::VOUCHER, $voucher->code);
        $voucher->status = VoucherStatus::USED;
        $voucher->save();

        return redirect()->back()->with('success', 'Voucher activated');
    }

    public function voucherHistory(CustomerVoucherHistoryDataTable $dataTable)
    {
        return $dataTable->render('customer.voucher.history');
    }
}
