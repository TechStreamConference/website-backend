<?php

namespace App\Controllers;

use App\Helpers\Role;
use App\Models\EventModel;
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

    public function applyAsSpeaker(): ResponseInterface
    {
        $event = $this->getEventForNewSpeakerApplication();
        if ($event instanceof ResponseInterface) {
            return $event;
        }

        $socialMediaLinkUpdateResult = $this->createSocialMediaLinksForCurrentUser();
        if ($socialMediaLinkUpdateResult->getStatusCode() !== 201) {
            return $socialMediaLinkUpdateResult;
        }

        // Reset current response to avoid returning the result of the createSocialMediaLinksForCurrentUser method.
        $this->response->setJSON([]);
        $this->response->setStatusCode(200);
        return $this->createOrUpdate($event['id']);
    }

    public function getApplicationEvent(): ResponseInterface
    {
        $event = $this->getEventForNewSpeakerApplication();
        if ($event instanceof ResponseInterface) {
            return $event;
        }

        return $this->response->setJSON(['event' => $event,])->setStatusCode(200);
    }

    private function getEventForNewSpeakerApplication(): array|ResponseInterface
    {
        // Preconditions to be able to apply as a speaker:
        // - The user must not already be a speaker (i.e. the user doesn't already have the speaker role).
        // - The user must not have a pending speaker application.
        // - There must be an event to apply for.
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

        $eventModel = model(EventModel::class);
        $latestPublishedEvent = $eventModel->getLatestPublished();
        if ($latestPublishedEvent === null) {
            return $this
                ->response
                ->setJSON(['error' => 'No event to apply for.'])
                ->setStatusCode(404);
        }

        return $latestPublishedEvent;
    }
}
