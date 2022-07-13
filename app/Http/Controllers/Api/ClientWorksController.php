<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Resources\WorkResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkCollection;

class ClientWorksController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Client $client)
    {
        $this->authorize('view', $client);

        $search = $request->get('search', '');

        $works = $client
            ->works()
            ->search($search)
            ->latest()
            ->paginate();

        return new WorkCollection($works);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $this->authorize('create', Work::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'date_start' => ['nullable', 'date'],
            'date_end' => ['nullable', 'date'],
            'hours' => ['nullable', 'numeric'],
            'cost' => ['nullable', 'numeric'],
            'statu_id' => ['required', 'exists:status,id'],
        ]);

        $work = $client->works()->create($validated);

        return new WorkResource($work);
    }
}
