<?php

namespace App\Observers;

use App\Models\Group;

class GroupObserver
{
    public function deleting(Group $group)
    {
        foreach ($group->users as $user) {
            $user->update(['group_id' => null]);
        }
    }
}