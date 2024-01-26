@php
    $action = $mode == 'edit' ? route('admin:service.bandwidth.update', $bandwidth) : route('admin:service.bandwidth.store');
    $method = $mode == 'edit' ? 'PATCH' : 'POST';
    $activeMenu = $mode == 'edit' ? 'service.bandwidth.edit' : 'service.bandwidth.create';
@endphp
<x-admin-layout title="{{ ucfirst($mode) }} Bandwidth Plans" :active-menu="$activeMenu" :path="[
    'List Bandwidth Plans' => route('admin:service.bandwidth.index'),
    ucfirst($mode) . ' Bandwidth Plans' => '',
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
                        <input type="hidden" name="id" value="{{ $bandwidth['id'] }}" />
                    @endif
                    <x-form.group.input name="name_bw" required :value="@$bandwidth['name_bw']" label="Bandwidth Name" />
                    <x-form.row>
                    <x-form.label label="Rate Download" required/>
                    <x-form.input name="rate_down" required :value="@$bandwidth['rate_down']" class="col-md-6"/>
                    <x-form.select name="rate_down_unit" nolabel :options="$rateUnits" required :value="@$bandwidth['rate_down_unit']->value ?? 'Kbps'"
                        class="col-md-3" />
                    </x-form>
                    <x-form.row>
                    <x-form.label label="Rate Upload" required/>
                    <x-form.input name="rate_up" required :value="@$bandwidth['rate_up']" class="col-md-6"/>
                    <x-form.select name="rate_up_unit" nolabel :options="$rateUnits" required :value="@$bandwidth['rate_up_unit']->value ?? 'Kbps'"
                        class="col-md-3"/>
                    </x-form.row>

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
