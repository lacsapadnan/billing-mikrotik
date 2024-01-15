<x-admin-layout title="Manage Router" active-menu="network.router" :path="['List Router' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable" action-label="Add New Router" :action-url="route('admin:network.router.create')"/>
    </div>
</x-admin-layout>
