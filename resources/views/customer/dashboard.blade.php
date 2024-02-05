@php
    $unpaid = \App\Models\PaymentGateway::where('username', auth()->user()->username)
        ->whereStatus(\App\Enum\PaymentGatewayStatus::UNPAID)
        ->first();
@endphp
<x-customer-layout title="Dashboard" active-menu="dashboard" :path="['Dashboard' => '']">
    <div class="app-container container-xxl">
        <div class="row g-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5 class="card-title text-white">Your Account Information</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td>USERNAME</td>
                                <td>{{ auth()->user()->username }}</td>
                            </tr>
                            <tr>
                                <td>PASSWORD</td>
                                <td class="py-0">
                                    <input type="password" value="{{ auth()->user()->password }}"
                                        class="form-control form-control-sm"
                                        style="width:120px;border: 0px; text-align: right;"
                                        onmouseleave="this.type = 'password'" onmouseenter="this.type = 'text'"
                                        onclick="this.select()" />
                                </td>
                            </tr>
                            <tr>
                                <td>SERVICE TYPE</td>
                                <td>{{ auth()->user()->service_type }}</td>
                            </tr>
                        </table>
                    </div>

                    @foreach (\App\Models\Customer::find(auth()->user()->id)->recharges as $bill)
                        <div class="card-header bg-primary">
                            <h5 class="card-title text-white">{{ $bill->router->name }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td>PLAN NAME</td>
                                    <td>{{ $bill->plan->name }}</td>
                                </tr>
                                <tr>
                                    <td>CREATED ON</td>
                                    <td>{{ $bill->created_at }}</td>
                                </tr>
                                <tr>
                                    <td @if (now() > $bill->expired_at) class="text-danger" @endif>EXPIRES ON</td>
                                    <td @if (now() > $bill->expired_at) class="text-danger" @endif>
                                        {{ $bill->expired_at }}</td>
                                </tr>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6 order-first order-md-last">
                @if ($unpaid)
                    <div class="card">
                        <div class="card-header bg-danger">
                            <h5 class="card-title text-white">Unpaid Order</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td>Expired</td>
                                    <td>{{ \App\Support\Lang::dateTimeFormat($unpaid->expired_date) }}</td>
                                </tr>
                                <tr>
                                    <td>Plan Name</td>
                                    <td>{{ $unpaid->plan_name }}</td>
                                </tr>
                                <tr>
                                    <td>Plan Price</td>
                                    <td>{{ \App\Support\Lang::moneyformat($unpaid->price) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">

                                        <div class="btn-group w-100" role="group" aria-label="Basic example">
                                            <a href="{{ route('customer:order.cancel', $unpaid) }}"
                                                class="btn btn-sm btn-danger">CANCEL</a>
                                            <a href="{{ route('customer:order.detail', $unpaid) }}"
                                                class="btn btn-sm btn-success">PAY NOW</a>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-customer-layout>
