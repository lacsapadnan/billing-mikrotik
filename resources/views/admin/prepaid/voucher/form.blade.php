@php
    $action = $mode == 'edit' ? route('admin:prepaid.voucher.update', $voucher) : route('admin:prepaid.voucher.store');
    $method = $mode == 'edit' ? 'PATCH' : 'POST';
    $activeMenu = $mode == 'edit' ? 'prepaid.voucher.edit' : 'prepaid.voucher.create';
@endphp
<x-admin-layout title="Add Voucher" :active-menu="$activeMenu" :path="['List Prepaid Voucher' => route('admin:prepaid.voucher.index'), 'Add Voucher' => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body" x-data="rechargeVoucherForm()" x-init="init()">

                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{ $action }}">
                    @method($method)
                    @csrf
                    @if ($mode == 'edit')
                        <input type="hidden" name="id" value="{{ $voucher['id'] }}" />
                    @endif
                    <x-form.group.select name="plan_type" label="Type" :options="$planTypes" required :value="@$voucher['plan_type'] ?? @$defaultPlanType?->value"
                        :readonly="$mode == 'edit'" />
                    <x-form.group.select name="router_id" label="Routers" :options="[]" required :value="@$voucher['router_id'] ?? @$defaultRouterId"
                        :readonly="$mode == 'edit'" />

                    <x-form.group.select name="plan_id" label="Service Plan" :options="[]" required
                        :value="@$voucher['plan_id']" />
                    <x-form.group.input name="count" type="number" required :value="1"
                        label="Number of Vouchers" />
                    <x-form.group.select name="format" :options="$voucherFormats" required :value="$defaultVoucherFormat" label="Voucher Format"/>
                    <x-form.group.input name="prefix" :value="@$defaultPrefix" label="Voucher Prefix"/>
                    <x-form.group.input name="length" type="number" required value="12" label="Length Code"/>

                    <div class="row py-5">
                        <div class="col-md-9 offset-md-3">
                            <div class="d-flex">
                                <button type="reset" onclick="window.history.back()" class="btn btn-light me-3">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    Generate
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
            window.rechargeVoucherForm = () => ({
                getRouter(planType, defaultValue) {
                    fetch("{{ route('admin:network.router.option') }}?plan_type=" + planType)
                        .then(res => res.json())
                        .then(res => {
                            $('[name="router_id"]').empty().select2({
                                data: [{
                                    id: "",
                                    text: ""
                                }, ...Object.entries(res).map(([key, value]) => {
                                    return {
                                        id: key,
                                        text: value
                                    }
                                })]
                            }).val(defaultValue).trigger('change')
                            this.getPlan($('[name="router_id"]').val(), @json($voucher['plan_id'] ?? ''))
                            @if ($mode != 'edit')
                                $('[name="router_id"]').on('change', (e) => {
                                    this.getPlan(e.target.value)
                                })
                            @endif
                        })
                },
                getPlan(routerId, defaultValue) {
                    const planType = $('[name="plan_type"]').val()
                    fetch("{{ route('admin:network.plan.option') }}?router_id=" + routerId + "&plan_type=" + planType)
                        .then(res => res.json())
                        .then(res => {
                            $('[name="plan_id"]').empty().select2({
                                data: [{
                                    id: "",
                                    text: ""
                                }, ...Object.entries(res).map(([key, value]) => {
                                    return {
                                        id: key,
                                        text: value
                                    }
                                })]
                            }).val(defaultValue).trigger('change')
                        })
                },
                init() {
                    this.getRouter($('[name="plan_type"]').val(), @json(@$defaultRouterId ?? ''))
                    $('[name="plan_type"]').on('change', (e) => {
                        this.getRouter(e.target.value)
                    })

                },

            })
        </script>
    @endpush
</x-admin-layout>
