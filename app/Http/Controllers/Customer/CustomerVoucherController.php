<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class CustomerVoucherController extends Controller
{
    public function voucher()
    {

        return view('customer.voucher.form');
    }
}
