<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserRechargeDataTable;
use App\DataTables\VoucherDataTable;
use App\Enum\PlanType;
use App\Enum\RechargeGateway;
use App\Enum\VoucherFormat;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Prepaid\PrepaidUserRequest;
use App\Http\Requests\Admin\Prepaid\PrepaidVoucherRequest;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Router;
use App\Models\Transaction;
use App\Models\UserRecharge;
use App\Models\Voucher;
use App\Support\Facades\Config;
use App\Support\Lang;
use App\Support\Mikrotik;
use App\Support\Package;
use Illuminate\Http\Request;

class AdminPrepaidController extends Controller
{
    public function user(UserRechargeDataTable $dataTable)
    {
        return $dataTable->render('admin.prepaid.user.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createUser()
    {
        $mode = 'add';
        $customers = Customer::all()->mapWithKeys(fn ($customer) => [
            $customer->id => $customer->username.' - '.$customer->fullname.' - '.$customer->email,
        ]);
        $planTypes = array_column(PlanType::cases(), 'value', 'value');
        $defaultPlanType = PlanType::HOTSPOT;

        return view('admin.prepaid.user.form', compact('mode', 'customers', 'planTypes', 'defaultPlanType'));
    }

    public function editUser(UserRecharge $user)
    {
        $mode = 'edit';
        $customers = Customer::where('id', $user->customer_id)->get()->mapWithKeys(fn ($customer) => [
            $customer->id => $customer->username.' - '.$customer->fullname.' - '.$customer->email,
        ]);
        $planTypes = array_column(PlanType::cases(), 'value', 'value');
        $defaultPlanType = $user->plan->type;
        $defaultRouterId = $user->plan->router_id;

        return view('admin.prepaid.user.form', compact('mode', 'customers', 'planTypes', 'defaultPlanType', 'user', 'defaultRouterId'));
    }

    public function storeUser(PrepaidUserRequest $request)
    {
        $customer = Customer::findOrFail($request->customer_id);
        $router = Router::findOrFail($request->router_id);
        $plan = Plan::findOrFail($request->plan_id);
        Package::rechargeUser($customer, $router, $plan, RechargeGateway::RECHARGE, auth()->user()->fullname);
        $invoice = Transaction::where('username', $customer->username)
            ->latest('id')->first();

        return redirect()->route('admin:prepaid.invoice.show', $invoice);
    }

    public function updateUser(PrepaidUserRequest $request, UserRecharge $user)
    {
        $customer = Customer::findOrFail($request->customer_id);
        $plan = Plan::findOrFail($request->plan_id);
        $user->plan_id = $request->plan_id;
        $user->expired_at = $request->expired_at;
        $user->save();

        Package::changeTo($customer, $plan, $user);

        return redirect()->route('admin:prepaid.user.index')->with('success', __('success.updated'));
    }

    public function destroyUser(UserRecharge $user)
    {
        if ($user->plan->is_radius) {
            //TODO: Radius::customerDeactivate
        } else {
            $mikrotik = $user->router;
            $client = Mikrotik::getClient($mikrotik->ip_address, $mikrotik->username, $mikrotik->password);
            if ($user->type == PlanType::HOTSPOT) {
                Mikrotik::removeHotspotUser($client, $user->username);
                Mikrotik::removeHotspotActiveUser($client, $user->username);
            } else {
                Mikrotik::removePpoeUser($client, $user->username);
                Mikrotik::removePpoeActive($client, $user->username);
            }
        }
        $user->delete();

        return redirect()->route('admin:prepaid.user.index')->with('success', __('success.deleted'));
    }

    public function showInvoice(Transaction $invoice)
    {
        $admin = auth()->user();
        $config = Config::get();

        return view('admin.prepaid.invoice.show', compact('invoice', 'admin', 'config'));
    }

    public function printInvoice(Transaction $invoice)
    {
        $admin = auth()->user();
        $config = Config::get();

        return view('admin.prepaid.invoice.print', compact('invoice', 'admin', 'config'));
    }

    public function voucher(VoucherDataTable $dataTable)
    {
        return $dataTable->render('admin.prepaid.voucher.list');
    }

    public function createVoucher()
    {
        $mode = 'add';
        $planTypes = array_column(PlanType::cases(), 'value', 'value');
        $defaultPlanType = PlanType::HOTSPOT;
        $voucherFormats = array_column(VoucherFormat::cases(), 'name', 'value');
        $defaultVoucherFormat = Config::get('voucher_format') ?: VoucherFormat::UPPERCASE->value;
        $defaultPrefix = Config::get('voucher_prefix');

        return view('admin.prepaid.voucher.form', compact('mode', 'planTypes', 'defaultPlanType', 'voucherFormats', 'defaultVoucherFormat', 'defaultPrefix'));
    }

    public function storeVoucher(PrepaidVoucherRequest $request)
    {
        if (! empty($request->prefix)) {
            Config::set('voucher_prefix', $request->prefix);
        }
        Config::set('voucher_format', $request->format);
        for ($i = 0; $i < $request->count; $i++) {
            $code = strtoupper(substr(md5(time().rand(10000, 99999)), 0, $request->length));
            $voucherFormat = VoucherFormat::from($request->format);
            if ($voucherFormat == VoucherFormat::lowercase) {
                $code = strtolower($code);
            } elseif ($voucherFormat == VoucherFormat::RaNdoM) {
                $code = Lang::randomUpLowCase($code);
            }
        }
        $request->merge([
            'code' => $request->prefix.$code,
        ]);
        Voucher::create($request->all());

        return redirect()->route('admin:prepaid.voucher.index')->with('success', __('success.created'));
    }

    public function destroyVoucher(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()->route('admin:prepaid.voucher.index')->with('success', __('success.deleted'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
