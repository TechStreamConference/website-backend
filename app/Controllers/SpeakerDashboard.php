<?php

namespace App\Controllers;

use App\Models\SpeakerModel;

class SpeakerDashboard extends ContributorDashboard
{
    #[\Override]
    protected function getModelClassName(): string
    {
        return SpeakerModel::class;
    }

    #[\Override]
    protected function getRoleName(): string
    {
        return 'speaker';
    }
}
