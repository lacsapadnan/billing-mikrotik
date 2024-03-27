<x-admin-layout title="Detail Contact" active-menu="customer" :path="['List Contact' => route('admin:customer.index'), 'Detail Contact' => '']">
    <div class="app-container container-xxl">
        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Content-->
            <div class="mb-10 flex-column flex-lg-row-auto w-lg-250px w-xl-350px">

                <!--begin::Card-->
                <div class="mb-5 card mb-xl-8">
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Summary-->


                        <!--begin::User Info-->
                        <div class="py-5 d-flex flex-center flex-column">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-100px symbol-circle mb-7">
                                <img src="{{ 'https://robohash.org/{$customer->id}?set=set3&size=100x100&bgset=bg1' }}"
                                    alt="image">
                            </div>
                            <!--end::Avatar-->

                            <!--begin::Name-->
                            <a href="#"
                                class="mb-3 text-gray-800 fs-3 text-hover-primary fw-bold">{{ $customer->fullname }}</a>
                            <!--end::Name-->
                        </div>
                        <!--end::User Info--> <!--end::Summary-->
                        <div class="py-3 d-flex flex-stack fs-4">
                            <div class="fw-bold">
                                Details
                            </div>

                            <div class="flex flex-row gap-2">

                                <form action="{{ route('admin:customer.destroy', $customer) }}" method="POST"
                                    x-data="confirmable({
                                        confirmTitle: 'Delete?',
                                        confirmButtonColor: 'var(--bs-danger)',
                                        onConfirm: () => $el.submit()
                                    })" @submit="confirm">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-light-danger confirmable">
                                        Delete
                                    </button>
                                </form>
                                <a href="{{ route('admin:customer.edit', $customer) }}"
                                    class="btn btn-sm btn-light-primary">
                                    Edit
                                </a>
                            </div>
                        </div>

                        <div class="separator"></div>

                        <!--begin::Details content-->
                        <div id="kt_user_view_details">
                            <div class="pb-5 fs-6">
                                <div class="mt-5 fw-bold">Username</div>
                                <div class="text-gray-600">{{ $customer->username }}</div>
                                <div class="mt-5 fw-bold">Phone</div>
                                <div class="text-gray-600">{{ $customer->phonenumber }}</div>
                                <div class="mt-5 fw-bold">Email</div>
                                <div class="text-gray-600"><a href="#"
                                        class="text-gray-600 text-hover-primary">{{ $customer->email }}</a></div>
                                <div class="mt-5 fw-bold">Address</div>
                                <div class="text-gray-600">{{ $customer->address }}</div>
                                <div class="mt-5 fw-bold">Password</div>
                                <div class="text-gray-600">
                                    <input type="password" value="{{ $customer['password'] }}" style=" border: 0px;"
                                        onmouseleave="this.type = 'password'" onmouseenter="this.type = 'text'"
                                        onclick="this.select()" />
                                </div>
                                <div class="mt-5 fw-bold">PPPOE Password</div>
                                <div class="text-gray-600">
                                    <input type="password" value="{{ $customer['pppoe_password'] }}"
                                        style=" border: 0px;" onmouseleave="this.type = 'password'"
                                        onmouseenter="this.type = 'text'" onclick="this.select()" />
                                </div>
                                <div class="mt-5 fw-bold">Service Type</div>
                                <div class="text-gray-600">{{ $customer->service_type }}</div>
                                <div class="mt-5 fw-bold">Auto Renewal</div>
                                <div class="text-gray-600">{{ $customer->auto_renewal ? 'Yes' : 'No' }}</div>
                                <div class="mt-5 fw-bold">Created On</div>
                                <div class="text-gray-600">{{ $customer->created_at?->format('d M Y H:i:s') }}</div>
                                <div class="mt-5 fw-bold">Last Login</div>
                                <div class="text-gray-600">{{ $customer->last_login?->format('d M Y H:i:s') }}</div>
                            </div>
                        </div>
                        <!--end::Details content-->

                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

                @if ($customer->recharge)
                    <div class="mb-5 card mb-xl-8">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Summary-->


                            <!--begin::User Info-->
                            <div class="py-5 text-white d-flex flex-center flex-column bg-success">
                                {{ $customer->recharge->plan->type->value }} - {{ $customer->recharge->plan->name }}
                            </div>
                            <!--end::User Info--> <!--end::Summary-->
                            <div class="separator"></div>

                            <!--begin::Details content-->
                            <div id="kt_user_view_details">
                                <div class="pb-5 fs-6">
                                    <div class="mt-5 fw-bold">Active</div>
                                    <div class="text-gray-600">{{ $customer->recharge->is_active ? 'Yes' : 'No' }}
                                    </div>
                                    <div class="mt-5 fw-bold">Created On</div>
                                    <div class="text-gray-600">
                                        {{ \App\Support\Lang::dateTimeFormat($customer->recharge->created_at) }}</div>
                                    <div class="mt-5 fw-bold">Expires On</div>
                                    <div class="text-gray-600">
                                        {{ \App\Support\Lang::dateTimeFormat($customer->recharge->expired_at) }}</div>
                                    <div class="mt-5 fw-bold">{{ $customer->recharge->router->name }}</div>
                                    <div class="text-gray-600">{{ $customer->recharge->method }}</div>
                                    <div class="mt-2">
                                        <a href="{{ route('admin:customer.deactivate', $customer) }}"
                                            class="btn btn-sm btn-danger">Deactivate</a>
                                        <a href="{{ route('admin:prepaid.user.recharge', $customer) }}"
                                            class="btn btn-sm btn-success">Recharge</a>
                                    </div>
                                </div>
                            </div>
                            <!--end::Details content-->

                        </div>
                        <!--end::Card body-->
                    </div>
                @else
                    <a class="btn btn-primary"
                        href="{{ route('admin:prepaid.user.recharge', $customer) }}">Recharge</a>
                @endif
            </div>
            <div class="flex-lg-row-fluid ms-lg-15">
                <!--begin:::Tabs-->
                <ul class="mb-8 border-0 nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x fs-4 fw-semibold">
                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4 {{ $tab == 'order' ? 'active' : '' }}"
                            href="{{ route('admin:customer.show', ['customer' => $customer, 'tab' => 'order']) }}"
                            role="tab" tabindex="-1">30 Order
                            History</a>
                    </li>
                    <!--end:::Tab item-->

                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4 {{ $tab == 'activation' ? 'active' : '' }}"
                            data-kt-countup-tabs="true"
                            href="{{ route('admin:customer.show', ['customer' => $customer, 'tab' => 'activation']) }}"
                            data-kt-initialized="1" role="tab">30 Activation History</a>
                    </li>
                    <!--end:::Tab item-->

                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4 {{ $tab == 'map' ? 'active' : '' }}"
                            data-kt-countup-tabs="true"
                            href="{{ route('admin:customer.show', ['customer' => $customer, 'tab' => 'map']) }}"
                            data-kt-initialized="1" role="tab">Map</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4 {{ $tab == 'ktp' ? 'active' : '' }}"
                            data-kt-countup-tabs="true"
                            href="{{ route('admin:customer.show', ['customer' => $customer, 'tab' => 'ktp']) }}"
                            data-kt-initialized="1" role="tab">KTP</a>
                    </li>
                    <!--end:::Tab item-->
                </ul>
                <!--end:::Tabs-->

                <!--begin:::Tab content-->
                <div class="tab-content" id="myTabContent">
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade active show" id="kt_user_view_order_tab" role="tabpanel">
                        <!--begin::Card-->
                        <div class="mb-6 card card-flush mb-xl-9">
                            <!--begin::Card body-->
                            <div class="pt-4 card-body p-9">

                                @if (@$dataTable)
                                    {{ $dataTable->table(['class' => 'table align-middle table-row-dashed table-row-fs-6 gy-5 dataTable'], true) }}
                                @endif
                                @if ($tab == 'map')
                                    <div style="width: 100%"><iframe width="100%" height="600" frameborder="0"
                                            scrolling="no" marginheight="0" marginwidth="0"
                                            src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q={{ $longitude }},%20{{ $latitude }}+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a
                                                href="https://www.gps.ie/">gps devices</a></iframe></div>
                                @endif
                                @if ($tab == 'ktp')
                                    <div class="mb-6 card card-flush mb-xl-9">
                                        <!--begin::Card body-->
                                        <div class="pt-4 card-body p-9">
                                            @if ($customer->ktp)
                                                <img src="{{ asset('storage/' . $customer->ktp) }}" alt="KTP Image"
                                                    width="250">
                                            @else
                                                <h2>Tidak ada KTP</h2>
                                            @endif

                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                @endif
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->

                    </div>
                    <!--end:::Tab pane-->

                </div>
                <!--end:::Tab content-->
            </div>
            <!--end::Content-->
        </div>
    </div>
    @if (@$dataTable)
        @push('addon-style')
            <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
                type="text/css" />
        @endpush
        @push('addon-script')
            <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
            {{ $dataTable->scripts() }}
        @endpush
    @endif
</x-admin-layout>
