<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductDescription;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductDescriptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productDescription can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list productdescriptions');
    }

    /**
     * Determine whether the productDescription can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductDescription  $model
     * @return mixed
     */
    public function view(User $user, ProductDescription $model)
    {
        return $user->hasPermissionTo('view productdescriptions');
    }

    /**
     * Determine whether the productDescription can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create productdescriptions');
    }

    /**
     * Determine whether the productDescription can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductDescription  $model
     * @return mixed
     */
    public function update(User $user, ProductDescription $model)
    {
        return $user->hasPermissionTo('update productdescriptions');
    }

    /**
     * Determine whether the productDescription can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductDescription  $model
     * @return mixed
     */
    public function delete(User $user, ProductDescription $model)
    {
        return $user->hasPermissionTo('delete productdescriptions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductDescription  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete productdescriptions');
    }

    /**
     * Determine whether the productDescription can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductDescription  $model
     * @return mixed
     */
    public function restore(User $user, ProductDescription $model)
    {
        return false;
    }

    /**
     * Determine whether the productDescription can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductDescription  $model
     * @return mixed
     */
    public function forceDelete(User $user, ProductDescription $model)
    {
        return false;
    }
}
