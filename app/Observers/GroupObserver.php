<?php

namespace App\Observers;

use App\Models\Group;

class GroupObserver
{
    public function saving(Group $group)
    {
        $group->domain_name = $group->name . '.eeyes.xyz';
        $group->db_username = 'db_' . $group->name;
        $group->db_password = encrypt(generate_password(16));
        $group->ftp_username = 'ftp_' . $group->name;
        $group->db_password = encrypt(generate_password(16));
    }
}