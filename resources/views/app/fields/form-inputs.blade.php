@php $editing = isset($field) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $field->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="html" label="Html" maxlength="255" required
            >{{ old('html', ($editing ? $field->html : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="enable"
            label="Enable"
            :checked="old('enable', ($editing ? $field->enable : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="preview" label="Preview" maxlength="255"
            >{{ old('preview', ($editing ? $field->preview : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
