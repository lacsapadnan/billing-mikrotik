<x-admin-layout title="Manage Contact" active-menu="customer.index" :path="['List Contact' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable" action-label="Add New Contact" :action-url="route('admin:customer.create')"/>
    </div>
</x-admin-layout>
