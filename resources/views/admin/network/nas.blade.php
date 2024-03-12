<x-admin-layout title="Manage Network Access Server" active-menu="network.nas" :path="['List NAS' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable" action-label="Add New NAS" :action-url="route('admin:network.nas.create')" />
    </div>
</x-admin-layout>