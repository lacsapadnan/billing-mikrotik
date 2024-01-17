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
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{ $action }}">
                    @method($method)
                    @csrf
                    @if ($mode == 'edit')
                        <input type="hidden" name="id" value="{{ $customer['id'] }}" />
                    @endif
                    <x-form.input name="username" required :value="@$customer['username']" />
                    <x-form.input name="fullname" required :value="@$customer['fullname']" />
                    <x-form.input name="email" required :value="@$customer['email']" />
                    <x-form.input name="phonenumber" required :value="@$customer['phonenumber']" />
                    <x-form.input name="password" required type="password" :value="@$customer['password']" />
                    <x-form.input name="pppoe_password" label="PPPOE Password" type="password" :value="@$customer['pppoe_password']"
                        tooltip="User Cannot change this, only admin. if it Empty it will use user password" />
                    <x-form.input name="address" type="textarea" :value="@$customer['address']" />
                    <x-form.select name="service_type" label="Service Type" :options="$serviceTypes" required
                        :value="@$customer['service_type']" />

                    <div class="row py-5">
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
