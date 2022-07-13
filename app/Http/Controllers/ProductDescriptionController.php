<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductDescription;
use App\Http\Requests\ProductDescriptionStoreRequest;
use App\Http\Requests\ProductDescriptionUpdateRequest;

class ProductDescriptionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ProductDescription::class);

        $search = $request->get('search', '');

        $productDescriptions = ProductDescription::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.product_descriptions.index',
            compact('productDescriptions', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', ProductDescription::class);

        $products = Product::pluck('name', 'id');
        $fields = Field::pluck('name', 'id');

        return view(
            'app.product_descriptions.create',
            compact('products', 'fields')
        );
    }

    /**
     * @param \App\Http\Requests\ProductDescriptionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductDescriptionStoreRequest $request)
    {
        $this->authorize('create', ProductDescription::class);

        $validated = $request->validated();

        $productDescription = ProductDescription::create($validated);

        return redirect()
            ->route('product-descriptions.edit', $productDescription)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductDescription $productDescription
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        ProductDescription $productDescription
    ) {
        $this->authorize('view', $productDescription);

        return view(
            'app.product_descriptions.show',
            compact('productDescription')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductDescription $productDescription
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        ProductDescription $productDescription
    ) {
        $this->authorize('update', $productDescription);

        $products = Product::pluck('name', 'id');
        $fields = Field::pluck('name', 'id');

        return view(
            'app.product_descriptions.edit',
            compact('productDescription', 'products', 'fields')
        );
    }

    /**
     * @param \App\Http\Requests\ProductDescriptionUpdateRequest $request
     * @param \App\Models\ProductDescription $productDescription
     * @return \Illuminate\Http\Response
     */
    public function update(
        ProductDescriptionUpdateRequest $request,
        ProductDescription $productDescription
    ) {
        $this->authorize('update', $productDescription);

        $validated = $request->validated();

        $productDescription->update($validated);

        return redirect()
            ->route('product-descriptions.edit', $productDescription)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductDescription $productDescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ProductDescription $productDescription
    ) {
        $this->authorize('delete', $productDescription);

        $productDescription->delete();

        return redirect()
            ->route('product-descriptions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
