<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ProductDescription;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDescriptionResource;
use App\Http\Resources\ProductDescriptionCollection;
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
            ->paginate();

        return new ProductDescriptionCollection($productDescriptions);
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

        return new ProductDescriptionResource($productDescription);
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

        return new ProductDescriptionResource($productDescription);
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

        return new ProductDescriptionResource($productDescription);
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

        return response()->noContent();
    }
}
