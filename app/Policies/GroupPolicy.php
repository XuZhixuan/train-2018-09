<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy extends Policy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param User $currentUser
     * @param Group $group
     * @return bool
     */
    public function delete(User $currentUser, Group $group)
    {
        return $currentUser->isUserOf($group);
    }
}
