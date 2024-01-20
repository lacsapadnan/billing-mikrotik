@props([
    'type' => 'text',
    'label' => ucfirst($name),
    'name' => '',
    'required' => false,
    'tooltip' => null,
    'value' => null,
])
<!--begin::Input group-->
<div {!! $attributes->merge(['class' => 'row fv-row fv-plugins-icon-container']) !!}>
    <x-form.label :label="$label" :required="$required" :tooltip="$tooltip" />

    <x-form.input :name="$name" :type="$type" :required="$required" :value="$value" {{ $attributes }}/>
</div>
<!--end::Input group-->
