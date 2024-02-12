<x-admin-layout title="Dashboard" active-menu="dashboard" :path="['Dashboard' => '']">
    <div class="app-container container-xxl">
        <div class="row gy-5 g-xl-10">
            <x-card.widget title="Income Today" :prefix="$config['currency_code']" :value="$incomeToday" icon="dollar" color="#3f42c1"
                :link="route('admin:report.activation')" link-title="View Reports" />
            <x-card.widget title="Income This Month" :prefix="$config['currency_code']" :value="$incomeThisMonth" icon="chart-simple"
                color="#3fa2c1" :link="route('admin:report.period')" link-title="View Reports" />
            <x-card.widget title="Users Active" :value="$userActive" icon="user" color="#ff7211" :link="route('admin:prepaid.user.index')"
                link-title="View All" />
            <x-card.widget title="Total Users" :value="$totalCustomer" icon="people" color="#cc7251" :link="route('admin:customer.index')"
                link-title="View All" />

            <div class="col-md-7">
                <div class="card mb-6">
                    <div class="card-header">
                        <div class="card-title">Vouchers Stock</div>
                    </div>
                    <div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Plan Name</th>
                                    <th>Unused</th>
                                    <th>Used</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plans as $plan)
                                    <tr>
                                        <td>{{ $plan->name }}</td>
                                        <td>{{ $plan->unused_vouchers }}</td>
                                        <td>{{ $plan->used_vouchers }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <div class="card-title">User Expired, Today</div>
                    </div>
                    <div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Created On</th>
                                    <th>Expires On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expireds as $expired)
                                    <tr>
                                        <td>
                                                {{$expired->id}}
                                        </td>
                                        <td>
                                            <a href="{{route('admin:customer.show', $expired->customer_id)}}">
                                            {{$expired->username}}</td>
                                            </a>
                                        <td>{{\App\Support\Lang::dateTimeFormat($expired->created_at)}}</td>
                                        <td>{{\App\Support\Lang::dateTimeFormat($expired->expired_at)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Activity Log</div>
                    </div>
                    <div class="p-6">
                        @foreach($logs as $log)
                            <div class="flex flex-col mb-3">
                                <span class="text-muted">{{$log->created_at->diffForHumans()}}</span>
                                <div>
                                    @if($log->loggable->user_type)[{{$log->loggable->user_type}}] @endif{{$log->description}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
