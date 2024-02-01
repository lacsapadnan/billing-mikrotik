<x-customer-layout title="Voucher" active-menu="voucher.order" :path="['Order Voucher' => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-title">
                <div class="alert-success p-4">
                Voucher Activation
                </div>
            </div>
            <div class="card-body">

                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{route('customer:voucher.activate')}}">
                    @csrf
                    <x-form.group.input required name="voucher_code" label="Voucher Code" placeholder="Enter voucher code here"/>
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
</x-customer-layout>
