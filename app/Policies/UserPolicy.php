<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    // TODO: user access control

    public function viewUsers(User $user): bool
    {
        return $user->hasPermissionTo('view-users-list');
    }

    public function viewUser(User $user, User $other): bool
    {
        if ($user->hasPermissionTo('view-users-details')) {
            return true;
        }
        return $this->viewOwnUser($user, $other);
    }

    public function viewOwnUser(User $user, User $other): bool
    {
        if ($user->hasPermissionTo('view-own-user')) {
            return $user->id === $other->id;
        }
        return false;
    }

    public function editUser(User $user, User $other): bool
    {
        if ($user->hasPermissionTo('edit-users')) {
            return true;
        }
        return $this->editOwnUser($user, $other);
    }

    public function editOwnUser(User $user, User $other): bool
    {
        if ($user->hasPermissionTo('edit-own-user')) {
            return $user->id === $other->id;
        }
        return false;
    }

    public function deleteUser(User $user, User $other): bool
    {
        if ($user->hasPermissionTo('delete-users')) {
            return true;
        }
        return $this->deleteOwnUser($user, $other);
    }

    public function deleteOwnUser(User $user, User $other): bool
    {
        if ($user->hasPermissionTo('delete-own-user')) {
            return $user->id === $other->id;
        }
        return false;
    }

    public function createUser(User $user): bool
    {
        return $user->hasPermissionTo('create-users');
    }

    public function viewUserAccess(User $user): bool
    {
        return $user->hasPermissionTo('view-user-access');
    }

    public function grantUserPermission(User $user): bool
    {
        return $user->hasPermissionTo('grant-user-permissions');
    }

    public function revokeUserPermission(User $user): bool
    {
        return $user->hasPermissionTo('revoke-user-permissions');
    }

    public function grantUserRole(User $user): bool
    {
        return $user->hasPermissionTo('grant-user-roles');
    }

    public function revokeUserRole(User $user): bool
    {
        return $user->hasPermissionTo('revoke-user-roles');
    }

}
