@props(['dataTable', 'actionUrl' => '', 'actionLabel' => ''])
<div class="card card-flush card-shadow">
    <div class="card-header !bg-gray-200">
        <div class="flex flex-row items-center w-full gap-5">
            <x-form.input name="search" placeholder="Search" class="col-md-6" id="dtb-search" value="" />
            @if($actionUrl)
            <a href="{{ $actionUrl }}" class="ml-auto">
                <x-primary-button>{{ $actionLabel }}</x-primary-button>
            </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        @if(@$filter)
        <div class="row">
            {{$filter}}
        </div>
        @endif
        {{ $dataTable->table(['class' => 'table align-middle table-row-dashed table-row-fs-6 gy-5 dataTable'], true) }}
    </div>
</div>
@push('addon-style')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('addon-script')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    {{ $dataTable->scripts() }}
@endpush
