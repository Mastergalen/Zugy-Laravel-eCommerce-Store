<?php

namespace App\Policies;

use App\User;

class BasePolicy
{
    protected $adminGroups = [1, 2]; //Super Admin and Admin
    protected $writeAccessGroups = [1, 2];

    protected function isAdmin(User $user)
    {
        return in_array($user->group_id, $this->adminGroups);
    }

    protected function hasWriteAccess(User $user)
    {
        return in_array($user->group_id, $this->writeAccessGroups);
    }
}