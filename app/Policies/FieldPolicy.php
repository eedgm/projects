<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Field;
use Illuminate\Auth\Access\HandlesAuthorization;

class FieldPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the field can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list fields');
    }

    /**
     * Determine whether the field can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Field  $model
     * @return mixed
     */
    public function view(User $user, Field $model)
    {
        return $user->hasPermissionTo('view fields');
    }

    /**
     * Determine whether the field can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create fields');
    }

    /**
     * Determine whether the field can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Field  $model
     * @return mixed
     */
    public function update(User $user, Field $model)
    {
        return $user->hasPermissionTo('update fields');
    }

    /**
     * Determine whether the field can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Field  $model
     * @return mixed
     */
    public function delete(User $user, Field $model)
    {
        return $user->hasPermissionTo('delete fields');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Field  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete fields');
    }

    /**
     * Determine whether the field can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Field  $model
     * @return mixed
     */
    public function restore(User $user, Field $model)
    {
        return false;
    }

    /**
     * Determine whether the field can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Field  $model
     * @return mixed
     */
    public function forceDelete(User $user, Field $model)
    {
        return false;
    }
}
