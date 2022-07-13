<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;
use App\Http\Requests\FieldStoreRequest;
use App\Http\Requests\FieldUpdateRequest;

class FieldController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Field::class);

        $search = $request->get('search', '');

        $fields = Field::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.fields.index', compact('fields', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Field::class);

        return view('app.fields.create');
    }

    /**
     * @param \App\Http\Requests\FieldStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FieldStoreRequest $request)
    {
        $this->authorize('create', Field::class);

        $validated = $request->validated();

        $field = Field::create($validated);

        return redirect()
            ->route('fields.edit', $field)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Field $field)
    {
        $this->authorize('view', $field);

        return view('app.fields.show', compact('field'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Field $field)
    {
        $this->authorize('update', $field);

        return view('app.fields.edit', compact('field'));
    }

    /**
     * @param \App\Http\Requests\FieldUpdateRequest $request
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function update(FieldUpdateRequest $request, Field $field)
    {
        $this->authorize('update', $field);

        $validated = $request->validated();

        $field->update($validated);

        return redirect()
            ->route('fields.edit', $field)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Field $field)
    {
        $this->authorize('delete', $field);

        $field->delete();

        return redirect()
            ->route('fields.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
