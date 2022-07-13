<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\WorkResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkCollection;

class ProductWorksController extends Controller
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

        $works = $product
            ->works()
            ->search($search)
            ->latest()
            ->paginate();

        return new WorkCollection($works);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', Work::class);

        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'date_start' => ['nullable', 'date'],
            'date_end' => ['nullable', 'date'],
            'hours' => ['nullable', 'numeric'],
            'cost' => ['nullable', 'numeric'],
            'statu_id' => ['required', 'exists:status,id'],
        ]);

        $work = $product->works()->create($validated);

        return new WorkResource($work);
    }
}
