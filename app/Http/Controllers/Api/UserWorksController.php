<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkCollection;

class UserWorksController extends Controller
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

        $works = $user
            ->works()
            ->search($search)
            ->latest()
            ->paginate();

        return new WorkCollection($works);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Work $work)
    {
        $this->authorize('update', $user);

        $user->works()->syncWithoutDetaching([$work->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user, Work $work)
    {
        $this->authorize('update', $user);

        $user->works()->detach($work);

        return response()->noContent();
    }
}
