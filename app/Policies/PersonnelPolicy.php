<?php

namespace App\Policies;

use App\Personnel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonnelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Personnel  $personnel
     * @return mixed
     */
    public function view(User $user, Personnel $personnel)
    {
        //if the user membership number is the same as the personnel membership number
        if ($user->membership_number == $personnel->employee_number || $user->hasRole('admin') || $user->hasRole('instructor')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //if user has the role of admin
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Personnel  $personnel
     * @return mixed
     */
    public function update(User $user, Personnel $personnel)
    {
        //if user has the role of admin
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Personnel  $personnel
     * @return mixed
     */
    public function delete(User $user, Personnel $personnel)
    {
        //if user has the role of admin
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Personnel  $personnel
     * @return mixed
     */
    public function restore(User $user, Personnel $personnel)
    {
        //if user has the role of admin
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Personnel  $personnel
     * @return mixed
     */
    public function forceDelete(User $user, Personnel $personnel)
    {
        //if user has the role of admin
        if ($user->hasRole('admin')) {
            return true;
        }
    }
}
