<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Status;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the status can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list statuses');
    }

    /**
     * Determine whether the status can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Status  $model
     * @return mixed
     */
    public function view(User $user, Status $model)
    {
        return $user->hasPermissionTo('view statuses');
    }

    /**
     * Determine whether the status can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create statuses');
    }

    /**
     * Determine whether the status can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Status  $model
     * @return mixed
     */
    public function update(User $user, Status $model)
    {
        return $user->hasPermissionTo('update statuses');
    }

    /**
     * Determine whether the status can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Status  $model
     * @return mixed
     */
    public function delete(User $user, Status $model)
    {
        return $user->hasPermissionTo('delete statuses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Status  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete statuses');
    }

    /**
     * Determine whether the status can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Status  $model
     * @return mixed
     */
    public function restore(User $user, Status $model)
    {
        return false;
    }

    /**
     * Determine whether the status can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Status  $model
     * @return mixed
     */
    public function forceDelete(User $user, Status $model)
    {
        return false;
    }
}
