@php
    $action = $mode == 'edit' ? route('admin:customer.update', $customer) : route('admin:customer.store');
    $method = $mode == 'edit' ? 'PATCH' : 'POST';
    $activeMenu = $mode == 'edit' ? 'customer.edit' : 'customer.create';
@endphp
<x-admin-layout title="{{ ucfirst($mode) }} Contact" :active-menu="$activeMenu" :path="['List Contact' => route('admin:customer.index'), ucfirst($mode) . ' Contact' => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body">



                <!--begin::Form-->
                <form class="flex flex-col gap-5 form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{ $action }}" enctype="multipart/form-data">
                    @method($method)
                    @csrf
                    @if ($mode == 'edit')
                        <input type="hidden" name="id" value="{{ $customer['id'] }}" />
                    @endif
                    <x-form.group.input name="username" required :value="@$customer['username']" />
                    <x-form.group.input name="fullname" required :value="@$customer['fullname']" />
                    <x-form.group.input name="email" required :value="@$customer['email']" />
                    <x-form.group.input name="phonenumber" required :value="@$customer['phonenumber']" />
                    <x-form.group.input name="password" required type="password" :value="@$customer['password']" />
                    <x-form.group.input name="pppoe_password" label="PPPOE Password" type="password" :value="@$customer['pppoe_password']"
                        tooltip="User Cannot change this, only admin. if it Empty it will use user password" />
                    <x-form.group.input name="address" type="textarea" :value="@$customer['address']" />
                    <x-form.group.select name="service_type" label="Service Type" :options="$serviceTypes" required :value="@$customer['service_type']" />
                    <x-form.group.input name="long" label="Longitude" type="text" :value="@$customer['long']" />
                    <x-form.group.input name="lat" label="Latitude" type="text" :value="@$customer['lat']" />
                    <x-form.group.input name="ktp" label="KTP (Identity Card)" type="file" accept=".pdf,.jpg,.jpeg,.png" />

                    <div class="py-5 row">
                        <div class="col-md-9 offset-md-3">
                            <div class="d-flex">
                                <button type="reset" onclick="window.history.back()" class="btn btn-light me-3">
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
