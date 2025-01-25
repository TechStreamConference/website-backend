<?php

namespace App\Filters;

use App\Helpers\Role;

class TeamMemberAuthFilter extends RoleAuthFilter
{
    public function __construct()
    {
        parent::__construct(Role::TEAM_MEMBER);
    }
}
