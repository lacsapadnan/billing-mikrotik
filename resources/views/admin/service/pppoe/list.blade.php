<x-admin-layout title="Manage Pppoe" active-menu="service.pppoe" :path="['List Pppoe' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable" action-label="Add New Pppoe" :action-url="route('admin:service.pppoe.create')"/>
    </div>
</x-admin-layout>
