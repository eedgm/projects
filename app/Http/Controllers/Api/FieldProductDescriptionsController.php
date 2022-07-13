<?php

namespace App\Http\Controllers\Api;

use App\Models\Field;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDescriptionResource;
use App\Http\Resources\ProductDescriptionCollection;

class FieldProductDescriptionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Field $field)
    {
        $this->authorize('view', $field);

        $search = $request->get('search', '');

        $productDescriptions = $field
            ->productDescriptions()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductDescriptionCollection($productDescriptions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Field $field)
    {
        $this->authorize('create', ProductDescription::class);

        $validated = $request->validate([
            'label' => ['required', 'max:255', 'string'],
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $productDescription = $field->productDescriptions()->create($validated);

        return new ProductDescriptionResource($productDescription);
    }
}
