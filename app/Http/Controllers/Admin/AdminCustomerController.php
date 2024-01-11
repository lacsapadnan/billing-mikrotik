<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CustomerDataTable;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Error;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index(CustomerDataTable $datatable)
    {
        return $datatable->render('admin.customer.list');
    }
    public function detail(Customer $customer){
        return view('admin.customer.detail', compact('customer'));
    }
    public function delete(Customer $customer){
        try{
        $customer->delete();
        return redirect()->to(route('admin:customer.list'))->with('success', 'Customer deleted successfully');
        }catch(Error $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
