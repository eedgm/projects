<div>
    <div>
        @can('create', App\Models\Work::class)
        <button class="button" wire:click="newWork">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Work::class)
        <button
            class="button button-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="mr-1 icon ion-md-trash text-primary"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="work.client_id"
                            label="Client"
                            wire:model="work.client_id"
                        >
                            <option value="null" disabled>Please select the Client</option>
                            @foreach($clientsForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="work.product_id"
                            label="Product"
                            wire:model="work.product_id"
                        >
                            <option value="null" disabled>Please select the Product</option>
                            @foreach($productsForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.date
                            name="workDateStart"
                            label="Date Start"
                            wire:model="workDateStart"
                            max="255"
                        ></x-inputs.date>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.date
                            name="workDateEnd"
                            label="Date End"
                            wire:model="workDateEnd"
                            max="255"
                        ></x-inputs.date>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="work.hours"
                            label="Hours"
                            wire:model="work.hours"
                            max="255"
                            step="0.01"
                            placeholder="Hours"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="work.cost"
                            label="Cost"
                            wire:model="work.cost"
                            max="255"
                            step="0.01"
                            placeholder="Cost"
                        ></x-inputs.number>
                    </x-inputs.group>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModal')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left w-1">
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.status_works.inputs.client_id')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.status_works.inputs.product_id')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.status_works.inputs.date_start')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.status_works.inputs.date_end')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.status_works.inputs.hours')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.status_works.inputs.cost')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($works as $work)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $work->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($work->client)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($work->product)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $work->date_start ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $work->date_end ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $work->hours ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $work->cost ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $work)
                            <button
                                type="button"
                                class="button"
                                wire:click="editWork({{ $work->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <div class="mt-10 px-4">{{ $works->render() }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
