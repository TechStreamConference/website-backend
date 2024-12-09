<?php

namespace App\Controllers;

use App\Helpers\Role;
use App\Models\RolesModel;
use App\Models\SpeakerModel;
use CodeIgniter\HTTP\ResponseInterface;

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

    public function applyAsSpeaker(int $eventId): ResponseInterface
    {
        // Preconditions to be able to apply as a speaker:
        // - The user must not already be a speaker (i.e. the user doesn't already have the speaker role).
        // - The user must not have a pending speaker application.
        $rolesModel = model(RolesModel::class);
        if ($rolesModel->hasRole($this->getLoggedInUserId(), Role::SPEAKER)) {
            return $this
                ->response
                ->setJSON(['error' => 'User cannot apply as speaker since they already are a speaker.'])
                ->setStatusCode(403);
        }

        $speakerModel = model(SpeakerModel::class);
        $eventsForUser = $speakerModel->getAllForUser($this->getLoggedInUserId());
        if (!empty($eventsForUser)) {
            return $this
                ->response
                ->setJSON(['error' => 'User cannot apply as speaker since they already have a pending application.'])
                ->setStatusCode(403);
        }

        return $this->createOrUpdate($eventId);
    }
}
