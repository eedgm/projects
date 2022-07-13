<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Status;
use App\Models\Client;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.statuses.index', compact('statuses', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Status::class);

        $clients = Client::pluck('name', 'id');
        $events = Event::pluck('name', 'id');

        return view('app.statuses.create', compact('clients', 'events'));
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

        return redirect()
            ->route('statuses.edit', $status)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Status $status
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Status $status)
    {
        $this->authorize('view', $status);

        return view('app.statuses.show', compact('status'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Status $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Status $status)
    {
        $this->authorize('update', $status);

        $clients = Client::pluck('name', 'id');
        $events = Event::pluck('name', 'id');

        return view(
            'app.statuses.edit',
            compact('status', 'clients', 'events')
        );
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

        return redirect()
            ->route('statuses.edit', $status)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('statuses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
