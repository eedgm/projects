@php $editing = isset($client) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $client->logo ? \Storage::url($client->logo) : '' }}')"
        >
            <x-inputs.partials.label
                name="logo"
                label="Logo"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input type="file" name="logo" id="logo" @change="fileChosen" />
            </div>

            @error('logo') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-8/12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $client->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.text
            name="owner"
            label="Owner"
            value="{{ old('owner', ($editing ? $client->owner : '')) }}"
            maxlength="255"
            placeholder="Owner"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-3/12">
        <x-inputs.text
            name="phone"
            label="Phone"
            value="{{ old('phone', ($editing ? $client->phone : '')) }}"
            maxlength="255"
            placeholder="Phone"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-3/12">
        <x-inputs.url
            name="website"
            label="Website"
            value="{{ old('website', ($editing ? $client->website : '')) }}"
            maxlength="250"
            placeholder="Website"
        ></x-inputs.url>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-3/12">
        <x-inputs.number
            name="cost_hour"
            label="Cost Hour"
            value="{{ old('cost_hour', ($editing ? $client->cost_hour : '')) }}"
            max="255"
            step="0.01"
            placeholder="Cost Hour"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-3/12">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $client->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="direction" label="Direction" maxlength="255"
            >{{ old('direction', ($editing ? $client->direction : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
