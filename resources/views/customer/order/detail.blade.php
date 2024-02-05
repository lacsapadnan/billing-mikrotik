<x-customer-layout title="Order Plan" active-menu="order.index" :path="['Order History' => route('customer:history.order'),'Order Detail' => '']">
    <div class="app-container container-xxl">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Transaction #{{ $order->id }}</div>
                    </div>
                    <div class="card-body">
                        <div class="p-2">
                            <div class="rounded shadow overflow-hidden">
                                <div class="bg-primary text-white p-2">
                                    {{ $order->router_name }}
                                </div>
                                <p class="p-2">
                                    {{ $order->router->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>Status</td>
                            <td>{{ $order->status->name }}</td>
                        </tr>
                        <tr>
                            <td>Expired</td>
                            <td>{{ \App\Support\Lang::dateTimeFormat($order->expired_date) }}</td>
                        </tr>
                        <tr>
                            <td>Plan Name</td>
                            <td>{{ $order->plan_name }}</td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>{{ \App\Support\Lang::moneyformat($order->plan->price) }}</td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td>{{ $order->plan->type->value }}</td>
                        </tr>
                        @if ($order->plan->type == \App\Enum\PlanType::HOTSPOT)
                            <tr>
                                <td>Plan Type</td>
                                <td>{{ $order->plan->typebp->value }}</td>
                            </tr>
                            @if ($order->plan->typebp == \App\Enum\PlanTypeBp::LIMITED)
                                @if (
                                    $order->plan->limit_type == \App\Enum\LimitType::TIME_LIMIT ||
                                        $order->plan->limit_type == \App\Enum\LimitType::BOTH_LIMIT)
                                    <tr>
                                        <td>Time Limit</td>
                                        <td>{{ $order->plan->time_limit_text }}</td>
                                    </tr>
                                @endif
                                @if (
                                    $order->plan->limit_type == \App\Enum\LimitType::DATA_LIMIT ||
                                        $order->plan->limit_type == \App\Enum\LimitType::BOTH_LIMIT)
                                    <tr>
                                        <td>Data Limit</td>
                                        <td>{{ $order->plan->data_limit_text }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endif
                        <tr>
                            <td>Plan Validity</td>
                            <td>{{ $order->plan->validity_text }}</td>
                        </tr>
                        <tr>
                            <td>Bandwidth Plans</td>
                            <td>{{ $order->plan->bandwidth->name_bw }}<br />
                                {{ $order->plan->bandwidth->rate_down_label }}/{{ $order->plan->bandwidth->rate_up_label }}
                            </td>
                        </tr>
                        @if($order->status == \App\Enum\PaymentGatewayStatus::UNPAID)
                        <tr>
                            <td colspan="2">
                                <div class="btn-group w-100" role="group" aria-label="Basic example">
                                    <a href="{{$order->pg_url_payment}}" class="btn btn-info">PAY NOW</a>
                                    <a href="{{route('customer:order.check',$order)}}" class="btn btn-primary">Check For Payment</a>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="{{route('customer:order.cancel', $order)}}" class="btn btn-sm btn-danger">CANCEL</a>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
