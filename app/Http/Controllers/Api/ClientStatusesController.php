<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use App\Http\Resources\StatusCollection;

class ClientStatusesController extends Controller
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

        $statuses = $client
            ->status()
            ->search($search)
            ->latest()
            ->paginate();

        return new StatusCollection($statuses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $this->authorize('create', Status::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'color' => ['required'],
            'event_id' => ['required', 'exists:events,id'],
        ]);

        $status = $client->status()->create($validated);

        return new StatusResource($status);
    }
}
