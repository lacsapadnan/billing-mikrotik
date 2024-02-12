<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ActivationHistoryDataTable;
use App\DataTables\CustomerDataTable;
use App\DataTables\OrderHistoryDataTable;
use App\Enum\PlanType;
use App\Enum\ServiceType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCustomerRequest;
use App\Models\Customer;
use App\Support\Facades\Log;
use App\Support\Mikrotik;
use Error;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index(CustomerDataTable $datatable)
    {
        return $datatable->render('admin.customer.list');
    }

    public function show(Request $request, Customer $customer, OrderHistoryDataTable $orderHistoryDataTable, ActivationHistoryDataTable $activationHistoryDataTable)
    {
        $tab = $request->tab ?? 'order';
        $request->merge(['username' => $customer->username]);
        if ($tab == 'order') {
            return $orderHistoryDataTable->render('admin.customer.detail', compact('customer', 'tab'));
        }
        if ($tab == 'activation') {
            return $activationHistoryDataTable->render('admin.customer.detail', compact('customer', 'tab'));
        }

        return view('admin.customer.detail', compact('customer', 'tab'));
    }

    public function edit(Customer $customer)
    {
        $mode = 'edit';
        $serviceTypes = array_column(ServiceType::cases(), 'value', 'value');

        return view('admin.customer.form', compact('customer', 'mode', 'serviceTypes'));
    }

    public function create()
    {
        $mode = 'add';
        $serviceTypes = array_column(ServiceType::cases(), 'value', 'value');

        return view('admin.customer.form', compact('mode', 'serviceTypes'));
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            Log::put('Delete customer '.$customer->username, auth()->user());

            return redirect()->to(route('admin:customer.index'))->with('success', __('success.deleted'));
        } catch (Error $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function store(AdminCustomerRequest $request)
    {
        Customer::query()->create($request->all());
        Log::put('Create customer '.$request->username, auth()->user());

        return redirect(route('admin:customer.index'))->with('success', __('success.created'));
    }

    public function update(Customer $customer, AdminCustomerRequest $request)
    {
        $customer->update($request->all());
        Log::put('Update customer '.$request->username, auth()->user());

        return redirect(route('admin:customer.index'))->with('success', __('success.updated'));
    }

    public function deactivate(Customer $customer)
    {
        $recharge = $customer->recharge;
        if ($recharge->plan->is_radius) {
            //TODO
        } else {
            $mikrotik = $recharge->router;
            $client = Mikrotik::getClient($mikrotik->ip_address, $mikrotik->username, $mikrotik->password);
            if ($recharge->type = PlanType::HOTSPOT) {
                Mikrotik::removeHotspotUser($client, $recharge->username);
                Mikrotik::removeHotspotActiveUser($client, $recharge->username);
            } else {
                Mikrotik::removePpoeUser($client, $recharge->username);
                Mikrotik::removePpoeActive($client, $recharge->username);
            }
        }
        $recharge->update([
            'status' => 'off',
            'expired_date' => now(),
        ]);
        Log::put('Deactivate customer '.$recharge->username, auth()->user());

        return redirect()->back()->with('success', __('Success deactivate customer to Mikrotik'));
    }
}
