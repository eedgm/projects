<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDescriptionResource;
use App\Http\Resources\ProductDescriptionCollection;

class ProductProductDescriptionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $product)
    {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $productDescriptions = $product
            ->productDescriptions()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductDescriptionCollection($productDescriptions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', ProductDescription::class);

        $validated = $request->validate([
            'label' => ['required', 'max:255', 'string'],
            'field_id' => ['required', 'exists:fields,id'],
        ]);

        $productDescription = $product
            ->productDescriptions()
            ->create($validated);

        return new ProductDescriptionResource($productDescription);
    }
}
