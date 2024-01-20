@php
    $action = $mode == 'edit' ? route('admin:network.pool.update', $pool) : route('admin:network.pool.store');
    $method = $mode == 'edit' ? 'PATCH' : 'POST';
    $activeMenu = $mode == 'edit'? 'network.pool.edit': 'network.pool.create';
@endphp
<x-admin-layout title="{{ ucfirst($mode) }} Pool" :active-menu="$activeMenu" :path="['List Pool' => route('admin:network.pool.index'), ucfirst($mode) . ' Pool' => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body">



                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST" action="{{ $action }}">
                    @method($method)
                    @csrf
                    @if ($mode == 'edit')
                    <input type="hidden" name="id" value="{{$pool['id']}}" />
                    @endif
                    <x-form.group.input name="pool_name" required :value="@$pool['pool_name']" label="Pool Name"/>
                    <x-form.group.input name="range_ip" required  :value="@$pool['range_ip']" label="Range IP" placeholder="ex: 244.178.44.2-244.178.44.111"/>
                    <x-form.group.select name="router_id" label="Router" :options="$routers" required :value="@$pool['router_id']??@$defaultRouterId"/>

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
