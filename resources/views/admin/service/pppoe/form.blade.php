@php
    $action = $mode == 'edit' ? route('admin:service.pppoe.update', $pppoe) : route('admin:service.pppoe.store');
    $method = $mode == 'edit' ? 'PATCH' : 'POST';
    $activeMenu = $mode == 'edit' ? 'service.pppoe.edit' : 'service.pppoe.create';
@endphp
<x-admin-layout title="{{ ucfirst($mode) }} Pppoe Plans" :active-menu="$activeMenu" :path="[
    'List Pppoe Plans' => route('admin:service.pppoe.index'),
    ucfirst($mode) . ' Pppoe Plans' => '',
]">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body" x-data="pppoeForm()" x-init="init()">
                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{ $action }}">
                    @method($method)
                    @csrf
                    @if ($mode == 'edit')
                        <input type="hidden" name="id" value="{{ $pppoe['id'] }}" />
                    @endif
                    <x-form.group.select name="enabled" label="Status" :options="['1' => 'Enabled', '0' => 'Disabled']" required :value="@$pppoe['enabled'] ?? 1" />
                    <x-form.group.input name="name" required :value="@$pppoe['name']" label="Plan Name" />
                    <x-form.group.select name="bandwidth_id" label="Bandwidth Name" :options="$bandwidths" required
                        :value="@$pppoe['bandwidth_id'] ?? $defaultBandwidth" />
                    <x-form.group.input name="price" type="number" required :value="@$pppoe['price']" label="Plan Price" />
                    <x-form.row>
                        <x-form.label label="Plan Validity" required />
                        <x-form.input name="validity" type="number" required :value="@$pppoe['validity']" label="Plan Validity"
                            class="col-md-6" />
                        <x-form.select name="validity_unit" nolabel :options="$validityUnits" required class="justify-end"
                            :value="@$pppoe['validity_unit']?->value ?? $defaultValidityUnit" class="col-md-3" />
                    </x-form.row>

                    <x-form.group.select name="router_id" label="Router Name" :options="$routers" required
                        :value="@$pppoe['router_id']" tooltip="Cannot be changed after saved" :readonly="$mode == 'edit'"/>
                    <x-form.group.select name="pool_id" label="IP Pool" :options="[]"
                        :value="@$pppoe['pool_id']" required/>
                    <x-form.group.select name="pool_expired_id" label="Expired IP Pool" :options="[]"
                        :value="@$pppoe['pool_expired_id']" />

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
            window.pppoeForm = () => ({
                getPools(name, routerId, defaultValue) {
                    fetch("{{ route('admin:network.pool.option') }}?router_id=" + routerId)
                        .then(res => res.json())
                        .then(res => {
                            $(`[name="${name}"]`).empty().select2({
                                data: [{id:"",text:""},...Object.entries(res).map(([key, value]) => {
                                    return {
                                        id: key,
                                        text: value
                                    }
                                })]
                            }).val(defaultValue).trigger('change')
                        })
                },
                submit(e) {
                    console.log(e)
                },
                init() {
                    this.getPools("pool_id",$('[name="router_id"]').val(),@json($pppoe['pool_id'] ?? ''))
                    this.getPools("pool_expired_id",$('[name="router_id"]').val(),@json($pppoe['pool_expired_id'] ?? ''))
                    $('[name="router_id"]').on('change', (e) => {
                        this.getPools("pool_id",e.target.value)
                        this.getPools("pool_expired_id",e.target.value)
                    })

                },
            })
        </script>
    @endpush
</x-admin-layout>
