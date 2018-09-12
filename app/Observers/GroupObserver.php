<?php

namespace App\Observers;

use App\Models\Group;

class GroupObserver
{
    public function saving(Group $group)
    {
        $group->domain_name = 'http://' . $group->name . '.eeyes.xyz';
        $group->db_username = 'db_' . $group->name;
        $group->db_password = encrypt(generate_password(16));
        $group->ftp_username = 'ftp_' . $group->name;
        $group->ftp_password = encrypt(generate_password(16));
    }

    public function deleting(Group $group)
    {
        foreach ($group->users as $user) {
            $user->update(['group_id' => null]);
        }
    }
}