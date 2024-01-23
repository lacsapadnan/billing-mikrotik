@props([
    'name' => '',
    'required' => false,
    'placeholder' => 'Select ' . ucfirst($name),
    'value' => '',
    'options' => [],
])

<div class="{{ $attributes->get('class')??'col-md-9'}}">
    <!--begin::Select2-->
    <select class="form-select form-select-solid" name="{{ $name }}" data-control="select2" @required($required)
        data-placeholder="{{ $placeholder }}" {{$attributes}}>
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
