<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CustomerDataTable;
use App\Enum\ServiceType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCustomerRequest;
use App\Models\Customer;
use Error;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index(CustomerDataTable $datatable)
    {
        return $datatable->render('admin.customer.list');
    }
    public function show(Customer $customer){
        return view('admin.customer.detail', compact('customer'));
    }
    public function edit(Customer $customer){
        $mode = 'edit';
        return view('admin.customer.form', compact('customer', 'mode'));
    }
    public function create(){
        $mode = 'add';
        $serviceTypes = array_column(ServiceType::cases(), 'value', 'value');
        return view('admin.customer.form', compact('mode', 'serviceTypes'));
    }
    public function destroy(Customer $customer){
        try{
        $customer->delete();
        return redirect()->to(route('admin:customer.list'))->with('success', __( 'success.customer.deleted'));
        }catch(Error $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    public function store(AdminCustomerRequest $request){
        Customer::query()->create($request->all());
        return redirect(route('admin:customer.list'))->with('success', __('success.customer.created'));
    }
}
