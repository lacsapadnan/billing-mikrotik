@php
    $action = $mode == 'edit' ? route('admin:customer.update', $customer) : route('admin:customer.store');
@endphp
<x-admin-layout title="{{ ucfirst($mode) }} Contact" active-menu="customer" :path="['List Contact' => route('admin:customer.list'), ucfirst($mode) . ' Contact' => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body">



                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{ $action }}">
                    @csrf
                    <x-form.input name="username" required />
                    <x-form.input name="fullname" required />
                    <x-form.input name="email" required />
                    <x-form.input name="phonenumber" required />
                    <x-form.input name="password" required type="password" />
                    <x-form.input name="pppoe_password" label="PPPOE Password" type="password"
                        tooltip="User Cannot change this, only admin. if it Empty it will use user password" />
                    <x-form.input name="address" type="textarea" />
                    <x-form.select name="service_type" label="Service Type" :options="$serviceTypes" required />

                    <div class="row py-5">
                        <div class="col-md-9 offset-md-3">
                            <div class="d-flex">
                                <button type="reset"
                                    class="btn btn-light me-3">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>

                </form>


            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</x-admin-layout>
