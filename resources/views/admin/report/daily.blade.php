<x-admin-layout title="Daily Reports" active-menu="report.daily" :path="['Daily Reports' => '']">
    <div class="app-container container-xxl">
        <x-datatable :dataTable="$dataTable" />
        <div class="text-info text-center py-4">All transactions at Date {{ \App\Support\Lang::dateTimeFormat(now()) }}</div>
    </div>
</x-admin-layout>
