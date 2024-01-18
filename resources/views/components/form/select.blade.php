@props([
    'label' => ucfirst($name),
    'name' => '',
    'required' => false,
    'tooltip' => null,
    'placeholder' => 'Select ' . @$label,
    'value' => '',
    'options' => [],
    'nolabel' => false,
])
<!--begin::Input group-->
<div {!! $attributes->merge(['class' => 'row fv-row fv-plugins-icon-container']) !!}>
    @if (!$nolabel)
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
    @endif

    <div class="col-md-9">
        <!--begin::Select2-->
        <select class="form-select form-select-solid" name="{{ $name }}" data-control="select2"
            @required($required) data-placeholder="{{ $placeholder }}">
            @foreach ($options as $val => $label)
                <option></option>
                <option value="{{ $val }}" @selected($value == $val)>{{ $label }}</option>
            @endforeach
        </select>
        <!--end::Select2-->
        @error($name)
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<!--end::Input group-->
