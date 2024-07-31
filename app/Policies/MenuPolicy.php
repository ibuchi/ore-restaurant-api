<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MenuPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Menu $menu): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->isStaff()
            ? Response::allow()
            : Response::deny('You do not have the permission to access this resource.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Menu $menu): Response
    {
        return $user->isStaff()
            ? Response::allow()
            : Response::deny('You do not have the permission to access this resource.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Menu $menu): Response
    {
        return $user->isStaff()
            ? Response::allow()
            : Response::deny('You do not have the permission to access this resource.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Menu $menu): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Menu $menu): bool
    {
        //
    }
}
