<?php

namespace App\Policies;

use App\Models\User;

class Policy
{
    /**
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        if ($user->isSuperUser()) {
            return true;
        }
    }
}