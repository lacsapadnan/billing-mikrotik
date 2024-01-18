<x-admin-layout title="Manage Bandwidth" active-menu="service.bandwidth" :path="['List Bandwidth' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable" action-label="Add New Bandwidth" :action-url="route('admin:service.bandwidth.create')"/>
    </div>
</x-admin-layout>
