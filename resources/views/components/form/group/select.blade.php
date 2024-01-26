@props([
    'label' => ucfirst($name),
    'name' => '',
    'required' => false,
    'tooltip' => null,
    'placeholder' => 'Select ' . @$label,
    'value' => '',
    'options' => [],
])
<!--begin::Input group-->
<div {!! $attributes->merge(['class' => 'row fv-row fv-plugins-icon-container']) !!}>
    <x-form.label :label="$label" :required="$required" :tooltip="$tooltip" />

    <x-form.select :name="$name" :options="$options" :required="$required" :value="$value" :placeholder="$placeholder" {{ $attributes }}/>
</div>
<!--end::Input group-->
