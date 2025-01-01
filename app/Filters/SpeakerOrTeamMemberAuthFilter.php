<?php

namespace App\Filters;

use App\Helpers\Role;

class SpeakerOrTeamMemberAuthFilter extends RoleAuthFilter
{
    public function __construct()
    {
        parent::__construct([Role::SPEAKER, Role::TEAM_MEMBER]);
    }
}
