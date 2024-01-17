<x-admin-layout title="Manage IP Pool" active-menu="network.router" :path="['IP Pool' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable" action-label="New Pool" :action-url="route('admin:network.pool.create')"/>
    </div>
</x-admin-layout>
