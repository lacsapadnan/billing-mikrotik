<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Router;

class CustomerOrderController extends Controller
{
    public function orderList()
    {
        $routers = Router::whereEnabled(true)->get();

        return view('customer.order.list', compact('routers'));
    }
}
