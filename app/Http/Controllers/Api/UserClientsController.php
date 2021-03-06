<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientCollection;

class UserClientsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $clients = $user
            ->clients()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClientCollection($clients);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Client::class);

        $validated = $request->validate([
            'logo' => ['image', 'max:1024', 'nullable'],
            'name' => ['required', 'max:255', 'string'],
            'owner' => ['required', 'max:255', 'string'],
            'phone' => ['nullable', 'max:255', 'string'],
            'website' => ['nullable', 'max:250', 'string'],
            'cost_hour' => ['required', 'numeric'],
            'direction' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('public');
        }

        $client = $user->clients()->create($validated);

        return new ClientResource($client);
    }
}
