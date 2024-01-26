@props([
    'label' => '',
    'required' => false,
    'tooltip' => null,
])
<div class="col-md-3 text-md-end">
    <!--begin::Label-->
    <label class="fs-6 fw-semibold form-label mt-3">
        <span @if ($required) class="required" @endif>{{ $label }}</span>
        @if ($tooltip)
            <span class="ms-1" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="{{ $tooltip }}"
                title="{{ $tooltip }}">
                <i class="ki-duotone ki-information-5 text-gray-500 fs-6"><span class="path1"></span><span
                        class="path2"></span><span class="path3"></span></i></span>
        @endif
    </label>
    <!--end::Label-->
</div>
