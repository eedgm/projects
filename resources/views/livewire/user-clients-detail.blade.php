<div>
    <div>
        @can('create', App\Models\Client::class)
        <button class="button" wire:click="newClient">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Client::class)
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
                        <x-inputs.text
                            name="client.owner"
                            label="Owner"
                            wire:model="client.owner"
                            maxlength="255"
                            placeholder="Owner"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="client.phone"
                            label="Phone"
                            wire:model="client.phone"
                            maxlength="255"
                            placeholder="Phone"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="client.name"
                            label="Name"
                            wire:model="client.name"
                            maxlength="255"
                            placeholder="Name"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="client.website"
                            label="Website"
                            wire:model="client.website"
                            maxlength="250"
                            placeholder="Website"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="client.logo"
                            label="Logo"
                            wire:model="client.logo"
                            maxlength="250"
                            placeholder="Logo"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.textarea
                            name="client.direction"
                            label="Direction"
                            wire:model="client.direction"
                            maxlength="255"
                        ></x-inputs.textarea>
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
                        @lang('crud.user_clients.inputs.owner')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.user_clients.inputs.phone')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.user_clients.inputs.name')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.user_clients.inputs.website')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.user_clients.inputs.logo')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.user_clients.inputs.direction')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($clients as $client)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $client->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $client->owner ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $client->phone ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $client->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $client->website ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $client->logo ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $client->direction ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $client)
                            <button
                                type="button"
                                class="button"
                                wire:click="editClient({{ $client->id }})"
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
                        <div class="mt-10 px-4">{{ $clients->render() }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
