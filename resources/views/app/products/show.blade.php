<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.products.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('products.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.products.inputs.client_id')
                        </h5>
                        <span
                            >{{ optional($product->client)->name ?? '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.products.inputs.name')
                        </h5>
                        <span>{{ $product->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.products.inputs.description')
                        </h5>
                        <span>{{ $product->description ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('products.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Product::class)
                    <a href="{{ route('products.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\ProductDescription::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Product Descriptions </x-slot>

                <livewire:product-product-descriptions-detail
                    :product="$product"
                />
            </x-partials.card>
            @endcan @can('view-any', App\Models\Work::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Works </x-slot>

                <livewire:product-works-detail :product="$product" />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
