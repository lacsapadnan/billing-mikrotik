@php
    $action = $mode == 'edit' ? route('admin:service.hotspot.update', $hotspot) : route('admin:service.hotspot.store');
    $method = $mode == 'edit' ? 'PATCH' : 'POST';
    $activeMenu = $mode == 'edit' ? 'service.hotspot.edit' : 'service.hotspot.create';
@endphp
<x-admin-layout title="{{ ucfirst($mode) }} Hotspot Plans" :active-menu="$activeMenu" :path="[
    'List Hotspot Plans' => route('admin:service.hotspot.index'),
    ucfirst($mode) . ' Hotspot Plans' => '',
]">
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
                        <input type="hidden" name="id" value="{{ $hotspot['id'] }}" />
                    @endif
                    <x-form.select name="enabled" label="Status" :options="['1' => 'Enabled', '0' => 'Disabled']" required :value="@$hotspot['enabled'] ?? 1" />
                    <x-form.input name="name" required :value="@$hotspot['name']" label="Plan Name" />
                    <x-form.select name="typebp" label="Plan Type" :options="$planTypes" required :value="@$hotspot['typebp'] ?? $defaultPlanType" />
                    <x-form.select name="bandwidth_id" label="Bandwidth Name" :options="$bandwidths" required
                        :value="@$hotspot['bandwidth_id'] ?? $defaultBandwidth" />
                    <x-form.input name="price" type="number" required :value="@$hotspot['price']" label="Plan Price" />
                    <x-form.input name="shared_users" type="number" required :value="@$hotspot['shared_users'] ?? 1" label="Shared Users"
                        tooltip="1 user can be used for many devices?" />
                    <x-form.input name="validity" type="number" required :value="@$hotspot['validity']" label="Plan Validity" />
                    <x-form.select name="validity_unit" nolabel :options="$validityUnits" required class="justify-end"
                        :value="@$hotspot['validity_unit'] ?? $defaultValidityUnit" />
                    <x-form.select name="router_id" label="Router Name" :options="$routers" required :value="@$hotspot['router_id']"
                        tooltip="Cannot be changed after saved" />

                    <x-form.select name="pool_expired" label="Expired IP Pool" :options="[]" required :value="@$hotspot['pool_expired']"/>

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
    @push('addon-script')
        <script>
            $(document).ready(() => {
                $('[name="router_id"]').on('change', (e) => {
                    fetch("{{route('admin:network.pool.option')}}?router_id=" + e.target.value)
                        .then(res => res.json())
                        .then(res => {
                            console.log(res);
                            $('[name="pool_expired"]').select2({
                                data: Object.entries(res).map(([key, value]) => {
                                    return {
                                        id: key,
                                        text: value
                                    }
                                })
                            })
                        })
                })
            })
        </script>
    @endpush
</x-admin-layout>
