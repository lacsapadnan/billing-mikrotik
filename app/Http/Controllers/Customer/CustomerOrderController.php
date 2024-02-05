<?php

namespace App\Http\Controllers\Customer;

use App\DataTables\OrderHistoryDataTable;
use App\Enum\PaymentGatewayStatus;
use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\Plan;
use App\Models\Router;
use App\Support\Facades\Xendit;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $routers = Router::whereEnabled(true)->get();

        return view('customer.order.list', compact('routers'));
    }

    public function buy(Plan $plan)
    {
        $user = auth()->user();
        if (strpos($user->email, '@') === false) {
            return redirect()->route('customer:profile.edit')->with('error', 'Please enter your email address');
        }
        Xendit::validateConfig();
        $order = PaymentGateway::where('username', $user->username)
            ->where('status', PaymentGatewayStatus::UNPAID)
            ->first();
        if ($order && $order->pg_url_payment) {
            return redirect()->route('customer:order.detail', $order)->with('error', 'You already have unpaid transaction, cancel it or pay it');
        }
        if (empty($order)) {
            $order = PaymentGateway::create([
                'username' => $user->username,
                'gateway' => 'xendit',
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'router_id' => $plan->router->id,
                'router_name' => $plan->router->name,
                'price' => $plan->price,
                'status' => PaymentGatewayStatus::UNPAID,
            ]);
        } else {
            $order->update([
                'username' => $user->username,
                'gateway' => 'xendit',
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'router_id' => $plan->router->id,
                'router_name' => $plan->router->name,
                'price' => $plan->price,
                'status' => PaymentGatewayStatus::UNPAID,
            ]);
        }

        return Xendit::createTransaction($order, $user);
    }

    public function detail(PaymentGateway $order)
    {
        if (empty($order->pg_url_payment)) {
            return redirect()->route('customer:order.buy', $order->plan)->with('error', 'Checking Payment');
        }

        return view('customer.order.detail', compact('order'));
    }

    public function check(PaymentGateway $order)
    {
        Xendit::validateConfig();
        try {
            Xendit::getStatus($order, auth()->user());

            return redirect()->route('customer:order.detail', $order)->with('success', 'Transaction has been paid');
        } catch (AppException $e) {
            return redirect()->route('customer:order.detail', $order)->with('error', $e->getMessage());
        }
    }

    public function cancel(PaymentGateway $order)
    {
        $order->update([
            'status' => PaymentGatewayStatus::CANCELED,
        ]);

        return redirect()->back()->with('success', 'Transaction has been canceled');
    }

    public function history(OrderHistoryDataTable $dataTable)
    {
        return $dataTable->render('customer.order.history');
    }
}
