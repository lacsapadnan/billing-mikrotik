@props([
    'name' => '',
    'required' => false,
    'placeholder' => 'Select ' . ucfirst($name),
    'value' => '',
    'options' => [],
    'select2' => true,
])

<div class="{{ $attributes->get('class') ?? 'col-md-9' }}">
    <!--begin::Select2-->
    <select class="form-select form-select-solid" name="{{ $name }}"
        @if ($select2) data-control="select2" @endif @required($required)
        data-placeholder="{{ $placeholder }}" {{ $attributes }}>
        <option></option>
        @foreach ($options as $val => $label)
            <option value="{{ $val }}" @selected($value == $val)>{{ $label }}</option>
        @endforeach
    </select>
    <!--end::Select2-->
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
