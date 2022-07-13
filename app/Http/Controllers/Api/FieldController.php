<?php

namespace App\Http\Controllers\Api;

use App\Models\Field;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FieldResource;
use App\Http\Resources\FieldCollection;
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
            ->paginate();

        return new FieldCollection($fields);
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

        return new FieldResource($field);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Field $field)
    {
        $this->authorize('view', $field);

        return new FieldResource($field);
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

        return new FieldResource($field);
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

        return response()->noContent();
    }
}
