<?php

namespace App\Http\Controllers\Api;

use App\Models\Work;
use Illuminate\Http\Request;
use App\Http\Resources\WorkResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkCollection;
use App\Http\Requests\WorkStoreRequest;
use App\Http\Requests\WorkUpdateRequest;

class WorkController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Work::class);

        $search = $request->get('search', '');

        $works = Work::search($search)
            ->latest()
            ->paginate();

        return new WorkCollection($works);
    }

    /**
     * @param \App\Http\Requests\WorkStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkStoreRequest $request)
    {
        $this->authorize('create', Work::class);

        $validated = $request->validated();

        $work = Work::create($validated);

        return new WorkResource($work);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Work $work)
    {
        $this->authorize('view', $work);

        return new WorkResource($work);
    }

    /**
     * @param \App\Http\Requests\WorkUpdateRequest $request
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\Response
     */
    public function update(WorkUpdateRequest $request, Work $work)
    {
        $this->authorize('update', $work);

        $validated = $request->validated();

        $work->update($validated);

        return new WorkResource($work);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Work $work)
    {
        $this->authorize('delete', $work);

        $work->delete();

        return response()->noContent();
    }
}
