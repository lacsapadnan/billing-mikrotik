@php
    $action = $mode == 'edit' ? route('admin:prepaid.user.update', $user) : route('admin:prepaid.user.store');
    $method = $mode == 'edit' ? 'PATCH' : 'POST';
    $activeMenu = $mode == 'edit' ? 'prepaid.user.edit' : 'prepaid.user.create';
@endphp
<x-admin-layout title="Recharge Account" :active-menu="$activeMenu" :path="['List Prepaid User' => route('admin:prepaid.user.index'), 'Recharge Account' => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body" x-data="rechargeUserForm()" x-init="init()">

                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{ $action }}">
                    @method($method)
                    @csrf
                    @if ($mode == 'edit')
                        <input type="hidden" name="id" value="{{ $user['id'] }}" />
                    @endif
                    <x-form.group.select name="customer_id" label="Select Account" :options="$customers" required
                        :value="@$user['customer_id']" :readonly="$mode == 'edit'"/>
                    <x-form.group.select name="plan_type" label="Type" :options="$planTypes" required :value="@$user['plan_type'] ?? @$defaultPlanType?->value" :readonly="$mode == 'edit'"/>
                    <x-form.group.select name="router_id" label="Routers" :options="[]" required
                                                          :value="@$user['router_id']??@$defaultRouterId" :readonly="$mode == 'edit'"/>

                    <x-form.group.select name="plan_id" label="Service Plan" :options="[]" required
                        :value="@$user['plan_id']" />
                    @if($mode == 'edit')
                        <x-form.group.input :disabled="true" name="created_at" type="datetime-local" :value="@$user['created_at']->format('Y-m-d H:i')" label="Created On"/>
                        <x-form.group.input name="expired_at" type="datetime-local" required :value="@$user['created_at']->format('Y-m-d H:i')" label="Expires On" />
                    @endif

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
            window.rechargeUserForm = () => ({
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
                            this.getPlan($('[name="router_id"]').val(), @json($user['plan_id'] ?? ''))
                            @if($mode != 'edit')
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
