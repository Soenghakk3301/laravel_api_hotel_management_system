<?php

namespace App\Policies;

use App\Models\Images;
use App\Models\User;
use App\Models\UserTypes;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Images  $images
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Images $images)
    {

    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return in_array($user->user_types_id, [UserTypes::IS_ADMIN, UserTypes::IS_STUFF]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Images  $images
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Images $images)
    {
        return in_array($user->user_types_id, [UserTypes::IS_ADMIN, UserTypes::IS_STUFF]);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Images  $images
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Images $images)
    {
        return in_array($user->user_types_id, [UserTypes::IS_ADMIN, UserTypes::IS_STUFF]);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Images  $images
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Images $images)
    {

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Images  $images
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Images $images)
    {

    }
}