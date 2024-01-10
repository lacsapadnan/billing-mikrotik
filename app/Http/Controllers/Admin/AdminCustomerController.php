<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index()
    {
        return view('admin.customer.list');
    }
}
