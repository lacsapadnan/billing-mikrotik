@php
@endphp
<x-admin-layout title="Settings" active-menu="setting.general" :path="['General Settings' => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{ route('admin:setting.general.update') }}">
                    @method('PUT')
                    @csrf
                    <h2>General Settings</h2>
                    <x-form.group.input name="CompanyName" required :value="@$config['CompanyName']" label="Application Name"/>
                    <x-form.group.input name="CompanyFooter" :value="@$config['CompanyFooter']" label="Company Footer"/>
                    <x-form.group.input type="textarea" name="address" :value="@$config['address']" label="Address"/>
                    <x-form.group.input name="phone" :value="@$config['phone']" label="Phone Number"/>
                    <x-form.group.input name="app_url" disabled :value="config('app.url')" label="App Url">
                        <x-slot:description>
                            edit at .env
                        </x-slot:description>
                    </x-form.group.input>
                    <h2>Voucher</h2>
                    <x-form.group.select name="disable_voucher" label="Disable Voucher" :options="['yes'=>'Yes', 'no' => 'No']"
                        :value="@$config['disable_voucher']??'no'" />
                    <x-form.group.select name="voucher_format" label="Voucher Format" :options="$voucherFormats"
                        :value="@$config['voucher_format']??'up'" />
                    <h2>Invoice</h2>
                    <x-form.group.input type="textarea" name="invoice_footer" :value="@$config['invoice_footer']" label="Invoice Footer"/>

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
