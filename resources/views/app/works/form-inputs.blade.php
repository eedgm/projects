@php $editing = isset($work) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.select name="client_id" label="Client" required>
            @php $selected = old('client_id', ($editing ? $work->client_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Client</option>
            @foreach($clients as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.select name="product_id" label="Product" required>
            @php $selected = old('product_id', ($editing ? $work->product_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Product</option>
            @foreach($products as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.date
            name="date_start"
            label="Date Start"
            value="{{ old('date_start', ($editing ? optional($work->date_start)->format('Y-m-d') : '')) }}"
            max="255"
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.date
            name="date_end"
            label="Date End"
            value="{{ old('date_end', ($editing ? optional($work->date_end)->format('Y-m-d') : '')) }}"
            max="255"
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-3/12">
        <x-inputs.number
            name="hours"
            label="Hours"
            value="{{ old('hours', ($editing ? $work->hours : '')) }}"
            max="255"
            step="0.01"
            placeholder="Hours"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-3/12">
        <x-inputs.number
            name="cost"
            label="Cost"
            value="{{ old('cost', ($editing ? $work->cost : '')) }}"
            max="255"
            step="0.01"
            placeholder="Cost"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-3/12">
        <x-inputs.select name="statu_id" label="Statu" required>
            @php $selected = old('statu_id', ($editing ? $work->statu_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Statu</option>
            @foreach($status as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
