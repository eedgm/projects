<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use App\Http\Resources\StatusCollection;

class EventStatusesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Event $event)
    {
        $this->authorize('view', $event);

        $search = $request->get('search', '');

        $statuses = $event
            ->status()
            ->search($search)
            ->latest()
            ->paginate();

        return new StatusCollection($statuses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Event $event)
    {
        $this->authorize('create', Status::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'color' => ['required'],
            'client_id' => ['required', 'exists:clients,id'],
        ]);

        $status = $event->status()->create($validated);

        return new StatusResource($status);
    }
}
