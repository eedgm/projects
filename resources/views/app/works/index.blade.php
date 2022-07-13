<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.works.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mt-4 mb-5">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="text-right md:w-1/2">
                            @can('create', App\Models\Work::class)
                            <a
                                href="{{ route('works.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.works.inputs.client_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.works.inputs.product_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.works.inputs.date_start')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.works.inputs.date_end')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.works.inputs.hours')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.works.inputs.cost')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.works.inputs.statu_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($works as $work)
                            <tr class="hover:bg-gray-50">
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
                                <td class="px-4 py-3 text-left">
                                    {{ optional($work->statu)->name ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="relative inline-flex align-middle "
                                    >
                                        @can('update', $work)
                                        <a
                                            href="{{ route('works.edit', $work) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-create"
                                                ></i>
                                            </button>
                                        </a>
                                        @endcan @can('view', $work)
                                        <a
                                            href="{{ route('works.show', $work) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $work)
                                        <form
                                            action="{{ route('works.destroy', $work) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="text-red-600  icon ion-md-trash"
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="9">
                                    <div class="px-4 mt-10">
                                        {!! $works->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
