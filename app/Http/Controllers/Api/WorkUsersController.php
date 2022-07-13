<?php
namespace App\Http\Controllers\Api;

use App\Models\Work;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class WorkUsersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Work $work)
    {
        $this->authorize('view', $work);

        $search = $request->get('search', '');

        $users = $work
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Work $work
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Work $work, User $user)
    {
        $this->authorize('update', $work);

        $work->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Work $work
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Work $work, User $user)
    {
        $this->authorize('update', $work);

        $work->users()->detach($user);

        return response()->noContent();
    }
}
