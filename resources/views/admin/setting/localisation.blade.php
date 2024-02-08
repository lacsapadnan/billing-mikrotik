@php
@endphp
<x-admin-layout title="Settings" active-menu="setting.localisation" :path="['Localisation Settings' => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{ route('admin:setting.localisation.update') }}">
                    @method('PUT')
                    @csrf
                    <h2>Localisation</h2>
                    <x-form.group.select name="date_format" label="Date Format" :options="[
                                               'd/m/Y' => date('d/M/Y'),
                                               'd.m.Y' => date('d.M.Y'),
                                               'd-m-Y' => date('d-M-Y'),
                                               'm/d/Y' => date('m/d/Y'),
                                               'Y/m/d' => date('Y/m/d'),
                                               'Y-m-d' => date('Y-m-d'),
                                               'M d Y' => date('M d Y'),
                                               'd M Y' => date('d M Y'),
                                               'jS M y' => date('jS M y'),
                                                            ]"
                        :value="@$config['date_format']" />
                    <x-form.group.input name="dec_point" :value="@$config['dec_point']" label="Decimal Point"/>
                    <x-form.group.input name="thousands_sep" :value="@$config['thousands_sep']" label="Thousands Separator"/>
                    <x-form.group.input name="currency_code" :value="@$config['currency_code']" label="Currency Code"/>
                    <x-form.group.input name="country_code_phone" :value="@$config['country_code_phone']" label="Country Code Phone" placeholder="62"/>

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
