<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserRechargeDataTable;
use App\Enum\PlanType;
use App\Enum\RechargeGateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Prepaid\PrepaidUserRequest;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Router;
use App\Models\Transaction;
use App\Support\Facades\Config;
use App\Support\Package;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
