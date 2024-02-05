<x-customer-layout title="Order History" active-menu="history.order" :path="['Order History' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable"/>
    </div>
</x-customer-layout>
