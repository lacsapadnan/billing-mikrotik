@aware(['description'])
@props([
    'type' => 'text',
    'name' => '',
    'required' => false,
    'value' => null,
])

<div class="{{ $attributes->get('class')??'col-md-9'}}">
    <!--begin::Input-->
    @if ($type == 'textarea')
        <textarea type="{{ $type }}" class="form-control form-control-solid" name="{{ $name }}"
            value="{{ old($name) ?? $value }}" @required($required)></textarea>
    @else
        <input type="{{ $type }}" class="form-control form-control-solid" name="{{ $name }}"
            value="{{ old($name) ?? $value }}" @required($required) {{ $attributes }}>
        <!--end::Input-->
    @endif
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
    @if($description)
        <span class="form-text text-muted">{!! $description !!}</span>
    @endif
</div>
