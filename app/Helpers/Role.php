<?php

namespace App\Helpers;

enum Role: string
{
    case ADMIN = 'admin';
    case SPEAKER = 'speaker';
    case TEAM_MEMBER = 'team_member';
}
