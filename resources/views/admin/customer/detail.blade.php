<x-admin-layout title="Detail Contact" active-menu="customer" :path="['List Contact' => route('admin:customer.index'), 'Detail Contact' => '']">
    <div class="app-container container-xxl">
        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Content-->
            <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">

                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Summary-->


                        <!--begin::User Info-->
                        <div class="d-flex flex-center flex-column py-5">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-100px symbol-circle mb-7">
                                <img src="{{ 'https://robohash.org/{$customer->id}?set=set3&size=100x100&bgset=bg1' }}"
                                    alt="image">
                            </div>
                            <!--end::Avatar-->

                            <!--begin::Name-->
                            <a href="#"
                                class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $customer->fullname }}</a>
                            <!--end::Name-->
                        </div>
                        <!--end::User Info--> <!--end::Summary-->
                        <div class="d-flex flex-stack fs-4 py-3">
                            <div class="fw-bold">
                                Details
                            </div>

                            <div class="flex flex-row gap-2">

                                <form action="{{ route('admin:customer.destroy', $customer) }}" method="POST"
                                    x-data="confirmable({
                                        confirmTitle: 'Delete?',
                                        confirmButtonColor: 'var(--bs-danger)',
                                        onConfirm: ()=>$el.submit()
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
                                <div class="fw-bold mt-5">Username</div>
                                <div class="text-gray-600">{{ $customer->username }}</div>
                                <div class="fw-bold mt-5">Phone</div>
                                <div class="text-gray-600">{{ $customer->phonenumber }}</div>
                                <div class="fw-bold mt-5">Email</div>
                                <div class="text-gray-600"><a href="#"
                                        class="text-gray-600 text-hover-primary">{{ $customer->email }}</a></div>
                                <div class="fw-bold mt-5">Address</div>
                                <div class="text-gray-600">{{ $customer->address }}</div>
                                <div class="fw-bold mt-5">Password</div>
                                <div class="text-gray-600">
                                    <input type="password" value="{{ $customer['password'] }}" style=" border: 0px;"
                                        onmouseleave="this.type = 'password'" onmouseenter="this.type = 'text'"
                                        onclick="this.select()" />
                                </div>
                                <div class="fw-bold mt-5">PPPOE Password</div>
                                <div class="text-gray-600">
                                    <input type="password" value="{{ $customer['pppoe_password'] }}"
                                        style=" border: 0px;" onmouseleave="this.type = 'password'"
                                        onmouseenter="this.type = 'text'" onclick="this.select()" />
                                </div>
                                <div class="fw-bold mt-5">Service Type</div>
                                <div class="text-gray-600">{{ $customer->service_type }}</div>
                                <div class="fw-bold mt-5">Auto Renewal</div>
                                <div class="text-gray-600">{{ $customer->auto_renewal ? 'Yes' : 'No' }}</div>
                                <div class="fw-bold mt-5">Created On</div>
                                <div class="text-gray-600">{{ $customer->created_at?->format('d M Y H:i:s') }}</div>
                                <div class="fw-bold mt-5">Last Login</div>
                                <div class="text-gray-600">{{ $customer->last_login?->format('d M Y H:i:s') }}</div>
                            </div>
                        </div>
                        <!--end::Details content-->

                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <div class="flex-lg-row-fluid ms-lg-15">
                <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8"
                    role="tablist">
                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                            href="#kt_user_view_order_tab" aria-selected="true" role="tab" tabindex="-1">30 Order
                            History</a>
                    </li>
                    <!--end:::Tab item-->

                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                            href="#kt_user_view_activation_tab" data-kt-initialized="1" aria-selected="false"
                            role="tab">30 Activation History</a>
                    </li>
                    <!--end:::Tab item-->
                </ul>
                <!--end:::Tabs-->

                <!--begin:::Tab content-->
                <div class="tab-content" id="myTabContent">
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade active show" id="kt_user_view_order_tab" role="tabpanel">
                        <!--begin::Card-->
                        <div class="card card-flush mb-6 mb-xl-9">
                            <!--begin::Card body-->
                            <div class="card-body p-9 pt-4">
                                TODO: order history
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->

                    </div>
                    <!--end:::Tab pane-->

                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade" id="kt_user_view_activation_tab" role="tabpanel">
                        <!--begin::Card-->
                        <div class="card card-flush mb-6 mb-xl-9">
                            <!--begin::Card body-->
                            <div class="card-body p-9 pt-4">
                                TODO: activation history
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
</x-admin-layout>
