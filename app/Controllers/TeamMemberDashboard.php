<?php

namespace App\Controllers;

use App\Models\TeamMemberModel;

class TeamMemberDashboard extends ContributorDashboard
{
    #[\Override]
    protected function getModelClassName(): string
    {
        return TeamMemberModel::class;
    }

    #[\Override]
    protected function getRoleName(): string
    {
        return 'team member';
    }
}
