<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\Client;
use App\Models\Status;
use App\Models\Product;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.works.index', compact('works', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Work::class);

        $clients = Client::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $status = Status::pluck('name', 'id');

        return view(
            'app.works.create',
            compact('clients', 'products', 'status')
        );
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

        return redirect()
            ->route('works.edit', $work)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Work $work)
    {
        $this->authorize('view', $work);

        return view('app.works.show', compact('work'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Work $work)
    {
        $this->authorize('update', $work);

        $clients = Client::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $status = Status::pluck('name', 'id');

        return view(
            'app.works.edit',
            compact('work', 'clients', 'products', 'status')
        );
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

        return redirect()
            ->route('works.edit', $work)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('works.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
