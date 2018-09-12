<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy extends Policy
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
}
