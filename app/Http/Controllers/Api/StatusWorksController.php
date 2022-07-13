<?php

namespace App\Http\Controllers\Api;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Resources\WorkResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkCollection;

class StatusWorksController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Status $status
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Status $status)
    {
        $this->authorize('view', $status);

        $search = $request->get('search', '');

        $works = $status
            ->works()
            ->search($search)
            ->latest()
            ->paginate();

        return new WorkCollection($works);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Status $status
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Status $status)
    {
        $this->authorize('create', Work::class);

        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'product_id' => ['required', 'exists:products,id'],
            'date_start' => ['nullable', 'date'],
            'date_end' => ['nullable', 'date'],
            'hours' => ['nullable', 'numeric'],
            'cost' => ['nullable', 'numeric'],
        ]);

        $work = $status->works()->create($validated);

        return new WorkResource($work);
    }
}
