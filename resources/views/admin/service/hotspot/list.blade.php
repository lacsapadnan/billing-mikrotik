<x-admin-layout title="Manage Hotspot" active-menu="service.hotspot" :path="['List Hotspot' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable" action-label="Add New Hotspot" :action-url="route('admin:service.hotspot.create')"/>
    </div>
</x-admin-layout>
