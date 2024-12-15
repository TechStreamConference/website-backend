<?php

namespace App\Filters;

use App\Helpers\Role;

class AdminAuthFilter extends RoleAuthFilter
{

    public function __construct()
    {
        parent::__construct(Role::ADMIN);
    }
}
