@php $editing = isset($productDescription) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="label"
            label="Label"
            value="{{ old('label', ($editing ? $productDescription->label : '')) }}"
            maxlength="255"
            placeholder="Label"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="product_id" label="Product" required>
            @php $selected = old('product_id', ($editing ? $productDescription->product_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Product</option>
            @foreach($products as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="field_id" label="Field" required>
            @php $selected = old('field_id', ($editing ? $productDescription->field_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Field</option>
            @foreach($fields as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
