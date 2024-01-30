<x-admin-layout title="Refill Account" active-menu="prepaid.refill-account" :path="['Refill Account' => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body">

                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{route('admin:prepaid.refill-account.store')}}">
                    @csrf
                    <x-form.group.select name="customer_id" :options="$customers" required label="Select Account"/>
                    <x-form.group.input name="voucher_code" required label="Voucher Code"/>

                    <div class="row py-5">
                        <div class="col-md-9 offset-md-3">
                            <div class="d-flex">
                                <button type="reset" onclick="window.history.back()" class="btn btn-light me-3">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    Recharge
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
