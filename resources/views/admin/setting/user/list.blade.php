<x-admin-layout title="Settings" active-menu="setting.user.index" :path="['Manage Administrator' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable" action-label="Add New Administrator" :action-url="route('admin:setting.user.create')"/>
    </div>
</x-admin-layout>
