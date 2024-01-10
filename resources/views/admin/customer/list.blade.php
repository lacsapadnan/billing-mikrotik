<x-admin-layout title="Manage Contact" active-menu="customer" :path="['List Contact' => '']">
    <div class="app-container container-xxl">
        <div class="card card-flush card-shadow">
            <div class="card-body">
                {{ $dataTable->table(['class' => 'table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer']) }}
            </div>
        </div>
    </div>
    @push('addon-style')
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    @push('addon-script')
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        {{ $dataTable->scripts() }}
    @endpush
</x-admin-layout>
