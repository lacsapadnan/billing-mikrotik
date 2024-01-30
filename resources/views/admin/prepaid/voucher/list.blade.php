<x-admin-layout title="Prepaid Vouchers" active-menu="prepaid.voucher" :path="['List Prepaid Voucher' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable" action-label="Add Voucher" :action-url="route('admin:prepaid.voucher.create')"/>
    </div>
</x-admin-layout>
