<?php

namespace App\Controllers;

use App\Helpers\Role;
use App\Models\EventModel;
use App\Models\RolesModel;
use App\Models\SpeakerModel;
use CodeIgniter\HTTP\ResponseInterface;

class SpeakerDashboard extends ContributorDashboard
{
    private const APPLICATION_RULES = [
        'application.name' => 'string|max_length[100]',
        'application.short_bio' => 'string|max_length[300]',
        'application.bio' => 'string',
        'application.photo_x' => 'integer',
        'application.photo_y' => 'integer',
        'application.photo_size' => 'integer',
    ];

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

    #[\Override]
    protected function getRoleNameScreamingSnakeCase(): string
    {
        return 'SPEAKER';
    }

    public function applyAsSpeaker(): ResponseInterface
    {
        $event = $this->getEventForNewSpeakerApplication();
        if ($event instanceof ResponseInterface) {
            return $event;
        }

        // Only create social media links if they were provided in the request.
        $data = $this->getJsonFromMultipartRequest();
        if ($data instanceof ResponseInterface) {
            return $data;
        }
        if (
            isset($data['social_media_links'])
            && is_array($data['social_media_links'])
            && count($data['social_media_links']) > 0
        ) {
            $socialMediaLinkUpdateResult = $this->createSocialMediaLinksForCurrentUser();
            if ($socialMediaLinkUpdateResult->getStatusCode() !== 201) {
                return $socialMediaLinkUpdateResult;
            }
            // Reset current response to avoid returning the result of the createSocialMediaLinksForCurrentUser method.
            $this->response->setJSON([]);
            $this->response->setStatusCode(200);
        }

        return $this->createFromApplication($event['id'], $data);
    }

    private function createFromApplication(int $eventId, array $data): ResponseInterface
    {
        if (!$this->validateData($data ?? [], self::APPLICATION_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();
        return $this->createNewEntry($validData['application'], $eventId);
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
            // User cannot apply as speaker since they already are a speaker.
            return $this
                ->response
                ->setJSON(['error' => 'USER_ALREADY_IS_SPEAKER'])
                ->setStatusCode(403);
        }

        $speakerModel = model(SpeakerModel::class);
        $eventsForUser = $speakerModel->getAllForUser($this->getLoggedInUserId());
        if (!empty($eventsForUser)) {
            // User cannot apply as speaker since they already have a pending application.
            return $this
                ->response
                ->setJSON(['error' => 'USER_ALREADY_HAS_PENDING_APPLICATION'])
                ->setStatusCode(403);
        }

        $eventModel = model(EventModel::class);
        $latestPublishedEvent = $eventModel->getLatestPublished();
        if ($latestPublishedEvent === null) {
            // No event to apply for.
            return $this
                ->response
                ->setJSON(['error' => 'NO_EVENT_TO_APPLY_FOR'])
                ->setStatusCode(404);
        }

        // Check if the current date is within the time period when speaker applications are accepted.
        // This depends on the "call_for_papers_start" and "call_for_papers_end" fields of the event.
        $currentDate = date('Y-m-d H:i:s');
        if ($currentDate < $latestPublishedEvent['call_for_papers_start'] || $currentDate > $latestPublishedEvent['call_for_papers_end']) {
            // Speaker applications are not accepted at this time.
            return $this
                ->response
                ->setJSON(['error' => 'CURRENTLY_NOT_ACCEPTING_SPEAKER_APPLICATIONS'])
                ->setStatusCode(403);
        }

        return $latestPublishedEvent;
    }
}
