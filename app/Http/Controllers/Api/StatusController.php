<?php

namespace App\Http\Controllers\Api;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use App\Http\Resources\StatusCollection;
use App\Http\Requests\StatusStoreRequest;
use App\Http\Requests\StatusUpdateRequest;

class StatusController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Status::class);

        $search = $request->get('search', '');

        $statuses = Status::search($search)
            ->latest()
            ->paginate();

        return new StatusCollection($statuses);
    }

    /**
     * @param \App\Http\Requests\StatusStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatusStoreRequest $request)
    {
        $this->authorize('create', Status::class);

        $validated = $request->validated();

        $status = Status::create($validated);

        return new StatusResource($status);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Status $status
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Status $status)
    {
        $this->authorize('view', $status);

        return new StatusResource($status);
    }

    /**
     * @param \App\Http\Requests\StatusUpdateRequest $request
     * @param \App\Models\Status $status
     * @return \Illuminate\Http\Response
     */
    public function update(StatusUpdateRequest $request, Status $status)
    {
        $this->authorize('update', $status);

        $validated = $request->validated();

        $status->update($validated);

        return new StatusResource($status);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Status $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Status $status)
    {
        $this->authorize('delete', $status);

        $status->delete();

        return response()->noContent();
    }
}
