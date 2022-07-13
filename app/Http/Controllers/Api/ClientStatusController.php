<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatuResource;
use App\Http\Resources\StatuCollection;

class ClientStatusController extends Controller
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

        $status = $client
            ->status()
            ->search($search)
            ->latest()
            ->paginate();

        return new StatuCollection($status);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $this->authorize('create', Statu::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'color' => ['required'],
            'event_id' => ['required', 'exists:events,id'],
        ]);

        $statu = $client->status()->create($validated);

        return new StatuResource($statu);
    }
}
