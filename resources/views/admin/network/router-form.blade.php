@php
    $action = $mode == 'edit' ? route('admin:customer.update', $router) : route('admin:customer.store');
    $method = $mode == 'edit' ? 'PATCH' : 'POST';
    $activeMenu = $mode == 'edit'? 'network.router.edit': 'network.router.create';
@endphp
<x-admin-layout title="{{ ucfirst($mode) }} Router" :active-menu="$activeMenu" :path="['List Router' => route('admin:network.router'), ucfirst($mode) . ' Router' => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body">



                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST" action="{{ $action }}">
                    @method($method)
                    @csrf
                    <x-form.select name="enabled" label="Status" :options="['1' => 'Enabled', '0' => 'Disabled']" required :value="@$router['enabled']??1"/>
                    <x-form.input name="name" required :value="@$router['name']" label="Router Name" tooltip="Name of Area that router operated"/>
                    <x-form.input name="ip_address" required  :value="@$router['ip_address']" label="IP Address"/>
                    <x-form.input name="username" required :value="@$router['username']"/>
                    <x-form.input name="password" required type="password" :value="@$router['password']" label="Router Secret"/>
                    <x-form.input name="description" type="textarea" :value="@$router['description']"/>

                    <div class="row py-5">
                        <div class="col-md-9 offset-md-3">
                            <div class="d-flex">
                                <button type="reset" onclick="window.history.back()"
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
