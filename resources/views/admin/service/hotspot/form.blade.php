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
            <div class="card-body" x-data="hotspotForm()" x-init="init()">
                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{ $action }}">
                    @method($method)
                    @csrf
                    @if ($mode == 'edit')
                        <input type="hidden" name="id" value="{{ $hotspot['id'] }}" />
                    @endif
                    <x-form.group.select name="enabled" label="Status" :options="['1' => 'Enabled', '0' => 'Disabled']" required :value="@$hotspot['enabled'] ?? 1" />
                    <x-form.group.input name="name" required :value="@$hotspot['name']" label="Plan Name" />
                    <x-form.group.select name="typebp" label="Plan Type" :options="$planTypes" required
                        :value="@$hotspot['typebp']?->value ?? $defaultPlanType" />
                    <template x-if="isLimited">
                        <x-form.group.select name="limit_type" label="Limit Type" :options="$limitTypes" required
                            :value="@$hotspot['limit_type']?->value ?? $defaultLimitType" />
                    </template>
                    <template x-if="isLimited && isTimeLimit">
                        <x-form.row>
                            <x-form.label label="Time Limit" />
                            <x-form.input name="time_limit" type="number" required :value="@$hotspot['time_limit']" label="Time Limit"
                                class="col-md-6" />
                            <x-form.select name="time_unit" nolabel :options="$timeUnits" required class="justify-end"
                                                                                                   :value="@$hotspot['time_unit']?->value ?? $defaultTimeUnit" class="col-md-3" />
                        </x-form.row>
                    </template>

                    <template x-if="isLimited && isDataLimit">
                        <x-form.row>
                            <x-form.label label="Data Limit" />
                            <x-form.input name="data_limit" type="number" required :value="@$hotspot['data_limit']"
                                label="Data Limit" class="col-md-6" />
                            <x-form.select name="data_unit" nolabel :options="$dataUnits" required class="justify-end"
                                                                                                   :value="@$hotspot['data_unit']?->value ?? $defaultDataUnit" class="col-md-3" />
                        </x-form.row>
                    </template>

                    <x-form.group.select name="bandwidth_id" label="Bandwidth Name" :options="$bandwidths" required
                        :value="@$hotspot['bandwidth_id'] ?? $defaultBandwidth" />
                    <x-form.group.input name="price" type="number" required :value="@$hotspot['price']" label="Plan Price" />
                    <x-form.group.input name="shared_users" type="number" required :value="@$hotspot['shared_users'] ?? 1"
                        label="Shared Users" tooltip="1 user can be used for many devices?" />

                    <x-form.row>
                        <x-form.label label="Plan Validity" required />
                        <x-form.input name="validity" type="number" required :value="@$hotspot['validity']" label="Plan Validity"
                            class="col-md-6" />
                        <x-form.select name="validity_unit" nolabel :options="$validityUnits" required class="justify-end"
                            :value="@$hotspot['validity_unit']?->value ?? $defaultValidityUnit" class="col-md-3" />
                    </x-form.row>

                    <x-form.group.select name="router_id" label="Router Name" :options="$routers" required
                        :value="@$hotspot['router_id']" tooltip="Cannot be changed after saved" :readonly="$mode == 'edit'"/>
                    <x-form.group.select name="pool_expired_id" label="Expired IP Pool" :options="[]"
                        :value="@$hotspot['pool_expired_id']" />

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
            window.hotspotForm = () => ({
                isLimited: false,
                isTimeLimit: false,
                isDataLimit: false,
                getPools(routerId, defaultValue) {
                    fetch("{{ route('admin:network.pool.option') }}?router_id=" + routerId)
                        .then(res => res.json())
                        .then(res => {
                            $('[name="pool_expired_id"]').empty().select2({
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
                    this.getPools($('[name="router_id"]').val(), @json($hotspot['pool_expired_id'] ?? ''))
                    $('[name="router_id"]').on('change', (e) => {
                        this.getPools(e.target.value)
                    })

                    this.isLimited = $('[name="typebp"]').val() == "Limited"
                    $('[name="typebp"]').on('change', (e) => {
                        this.isLimited = e.target.value == "Limited"
                    })

                    setTimeout(() => {
                        this.setLimitOption();
                    }, 200)
                    this.$watch("isLimited", (value) => {
                        if (value) {
                            this.setLimitOption()
                        }
                    })
                },
                setLimitOption() {
                    $('[name="limit_type"]').select2()
                    $('[name="time_unit"]')?.select2()
                    $('[name="data_unit"]')?.select2()
                    this.isTimeLimit = $('[name="limit_type"]').val() == "Time_Limit" || $(
                            '[name="limit_type"]')
                        .val() == "Both_Limit"
                    this.isDataLimit = $('[name="limit_type"]').val() == "Data_Limit" || $(
                            '[name="limit_type"]')
                        .val() == "Both_Limit"
                    $('[name="limit_type"]').on('change', (e) => {
                        this.isTimeLimit = e.target.value == "Time_Limit" || e.target.value ==
                            "Both_Limit"
                        this.isDataLimit = e.target.value == "Data_Limit" || e.target.value ==
                            "Both_Limit"
                    })
                }

            })
        </script>
    @endpush
</x-admin-layout>
