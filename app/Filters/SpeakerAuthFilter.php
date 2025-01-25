<?php

namespace App\Filters;

use App\Helpers\Role;

class SpeakerAuthFilter extends RoleAuthFilter
{
    public function __construct()
    {
        parent::__construct(Role::SPEAKER);
    }
}
