<?php

namespace App\Policies;

use App\Models\Work;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the work can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list works');
    }

    /**
     * Determine whether the work can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Work  $model
     * @return mixed
     */
    public function view(User $user, Work $model)
    {
        return $user->hasPermissionTo('view works');
    }

    /**
     * Determine whether the work can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create works');
    }

    /**
     * Determine whether the work can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Work  $model
     * @return mixed
     */
    public function update(User $user, Work $model)
    {
        return $user->hasPermissionTo('update works');
    }

    /**
     * Determine whether the work can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Work  $model
     * @return mixed
     */
    public function delete(User $user, Work $model)
    {
        return $user->hasPermissionTo('delete works');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Work  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete works');
    }

    /**
     * Determine whether the work can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Work  $model
     * @return mixed
     */
    public function restore(User $user, Work $model)
    {
        return false;
    }

    /**
     * Determine whether the work can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Work  $model
     * @return mixed
     */
    public function forceDelete(User $user, Work $model)
    {
        return false;
    }
}
