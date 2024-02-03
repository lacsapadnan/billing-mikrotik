<x-customer-layout title="Order Plan" active-menu="order.index" :path="['Order Internet Package' => '']">
    <div class="app-container container-xxl">

        @foreach ($routers as $router)
            <div class="row g-5">
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="card-title text-white">{{ $router->name }}</h5>
                        </div>
                        <div>
                            <div class="p-4 bg-secondary">HOTSPOT Plan</div>
                            <div class="row g-5 p-6">
                                @foreach ($router->plans()->where('type', \App\Enum\PlanType::HOTSPOT)->get() as $plan)
                                    <div class="col-md-4">
                                        <div class="card card-dashed">
                                            <div class="card-body p-0">
                                                <table class="table table-bordered table-striped">
                                                    <tr>
                                                        <td colspan="2" class="text-center bg-success">
                                                            {{ $plan->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Price</td>
                                                        <td>
                                                            {{\App\Support\Lang::moneyformat($plan->price)}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Validity</td>
                                                        <td>{{ $plan->validity_text}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <a href="{{route('customer:order.buy', $plan)}}" class="btn btn-warning btn-sm w-full">
                                                                BUY
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
<div>
                            <div class="p-4 bg-secondary">PPPOE Plan</div>
                            <div class="row g-5 p-6">
                                @foreach ($router->plans()->where('type', \App\Enum\PlanType::PPPOE)->get() as $plan)
                                    <div class="col-md-4">
                                        <div class="card card-dashed">
                                            <div class="card-body p-0">
                                                <table class="table table-bordered table-striped">
                                                    <tr>
                                                        <td colspan="2" class="text-center bg-success">
                                                            {{ $plan->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Price</td>
                                                        <td>
                                                            {{\App\Support\Lang::moneyformat($plan->price)}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Validity</td>
                                                        <td>{{ $plan->validity_text}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <a href="{{route('customer:order.buy', $plan)}}" class="btn btn-warning btn-sm w-full">
                                                                BUY
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
</x-customer-layout>
