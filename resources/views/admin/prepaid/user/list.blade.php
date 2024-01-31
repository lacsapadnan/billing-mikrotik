<x-admin-layout title="Prepaid Users" active-menu="prepaid.user" :path="['List Prepaid User' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable" action-label="Recharge Account" :action-url="route('admin:prepaid.user.create')"/>
    </div>
</x-admin-layout>
