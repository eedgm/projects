@php $editing = isset($event) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $event->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="process"
            label="Process"
            maxlength="255"
            required
            >{{ old('process', ($editing ? $event->process : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
