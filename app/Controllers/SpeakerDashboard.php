<?php

namespace App\Controllers;

use App\Helpers\EmailHelper;
use App\Helpers\Role;
use App\Helpers\VideoLinkType;
use App\Helpers\VideoRoomHelper;
use App\Helpers\VideoSourceType;
use App\Models\AccountModel;
use App\Models\EventModel;
use App\Models\RolesModel;
use App\Models\SpeakerModel;
use App\Models\TalkModel;
use App\Models\VideoRoomModel;
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

        $data = $this->getJsonFromMultipartRequest();
        if ($data instanceof ResponseInterface) {
            return $data;
        }

        $result = $this->createNewSpeakerEntryFromApplication($event['id'], $data);
        $returnCode = $result->getStatusCode();

        if ($returnCode !== 201) {
            return $result;
        }

        // Only create social media links if they were provided in the request.
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
            $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_OK);
        }

        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($this->getLoggedInUserId());
        $username = $account['username'];

        EmailHelper::sendToAdmins(
            subject: "{$this->getRoleName()}-Bewerbung",
            message: view(
                'email/admin/contributor_new_entry',
                [
                    'role' => $this->getRoleName(),
                    'username' => $username,
                ],
            )
        );

        return $result;
    }

    private function createNewSpeakerEntryFromApplication(int $eventId, array $data): ResponseInterface
    {
        if (!$this->validateData($data ?? [], self::APPLICATION_RULES)) {
            return $this
                ->response
                ->setJSON($this->validator->getErrors())
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        $validData = $this->validator->getValidated();
        return $this->createNewContributorEntry($validData['application'], $eventId);
    }

    public function getApplicationEvent(): ResponseInterface
    {
        $event = $this->getEventForNewSpeakerApplication();
        if ($event instanceof ResponseInterface) {
            return $event;
        }

        return $this
            ->response
            ->setJSON(['event' => $event])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function videoRoomExists(): ResponseInterface
    {
        $videoRoom = $this->tryGetVideoRoomForCurrentUser();

        return $this
            ->response
            ->setJSON(['exists' => $videoRoom !== null])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function getVideoRoom(): ResponseInterface
    {
        $videoRoom = $this->tryGetVideoRoomForCurrentUser();

        if ($videoRoom === null) {
            return $this
                ->response
                ->setJSON(['error' => 'VIDEO_ROOM_DOES_NOT_EXIST'])
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $eventId = $videoRoom['event_id'];

        $userId = $this->getLoggedInUserId();
        $speakerModel = model(SpeakerModel::class);
        $speaker = $speakerModel->getLatestApprovedForEvent($userId, $eventId);

        $links = [];
        foreach (VideoSourceType::cases() as $sourceType) {
            $links[VideoLinkType::PUSH->value . "_{$sourceType->value}"] =
                VideoRoomHelper::createVideoLink(
                    $videoRoom['base_url'],
                    $videoRoom['room_id'],
                    $videoRoom['password'],
                    $eventId,
                    $userId,
                    $speaker['name'],
                    VideoLinkType::PUSH,
                    $sourceType
                );

        }

        return $this
            ->response
            ->setJSON($links)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    private function tryGetVideoRoomForCurrentUser(): ?array
    {
        $eventModel = model(EventModel::class);
        $publishedEvents = $eventModel->getAllPublished();

        // We have to check if there's an event that is not yet over, has a video room, and
        // the video room is visible. Also, the user must have at least one accepted talk for
        // that event.
        $upcomingOrOngoingEvents = array_filter($publishedEvents, function (array $event) {
            return date($event['end_date']) >= date('Y-m-d');
        });
        if (empty($upcomingOrOngoingEvents)) {
            return null;
        }

        // Sort from newest to oldest.
        usort($upcomingOrOngoingEvents, function (array $a, array $b) {
            return date($b['start_date']) <=> date($a['start_date']);
        });

        $talkModel = model(TalkModel::class);
        $userId = $this->getLoggedInUserId();
        $videoRoomModel = model(VideoRoomModel::class);
        $room = null;
        foreach ($upcomingOrOngoingEvents as $upcomingOrOngoingEvent) {
            $videoRoom = $videoRoomModel->get($upcomingOrOngoingEvent['id']);
            if ($videoRoom === null) {
                // No video room for this event.
                continue;
            }

            $isVisible = $videoRoom['visible_from'] !== null && $videoRoom['visible_from'] <= date('Y-m-d H:i:s');
            if (!$isVisible) {
                // Video room is not visible yet.
                continue;
            }

            $allAcceptedTalks = $talkModel->getAllWithAcceptedTimeSlot($upcomingOrOngoingEvent['id']);
            $speakerHasTalks = false;
            foreach ($allAcceptedTalks as $talk) {
                if ($talk['user_id'] === $userId) {
                    $speakerHasTalks = true;
                    break;
                }
            }
            if (!$speakerHasTalks) {
                // Speaker doesn't have any accepted talks for this event.
                continue;
            }

            $room = $videoRoom;
            break;
        }

        return $room; // Maybe null.
    }

    private function getEventForNewSpeakerApplication(): array|ResponseInterface
    {
        // Preconditions to be able to apply as a speaker:
        // - There must be an event to apply for.
        // - The user must not already be a speaker for that event (i.e. the user doesn't already have an approved
        //   speaker entry for that event).
        // - The user must not have a pending speaker application for that year (i.e. the user doesn't have a
        //   speaker entry for that year, that is not approved).
        $eventModel = model(EventModel::class);
        $latestPublishedEvent = $eventModel->getLatestPublished();
        if ($latestPublishedEvent === null) {
            // No event to apply for.
            return $this
                ->response
                ->setJSON(['error' => 'NO_EVENT_TO_APPLY_FOR'])
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        // Check if the current date is within the time period when speaker applications are accepted.
        // This depends on the "call_for_papers_start" and "call_for_papers_end" fields of the event.
        $currentDate = date('Y-m-d H:i:s');
        if ($currentDate < $latestPublishedEvent['call_for_papers_start'] || $currentDate > $latestPublishedEvent['call_for_papers_end']) {
            // Speaker applications are not accepted at this time.
            return $this
                ->response
                ->setJSON(['error' => 'CURRENTLY_NOT_ACCEPTING_SPEAKER_APPLICATIONS'])
                ->setStatusCode(ResponseInterface::HTTP_FORBIDDEN);
        }

        // Get all speaker entries of the logged in user for that event.
        $eventId = $latestPublishedEvent['id'];
        $userId = $this->getLoggedInUserId();
        $speakerModel = model(SpeakerModel::class);
        $allSpeakerEntries = $speakerModel->getAllForUserAndEvent($userId, $eventId);

        if (!empty($allSpeakerEntries)) {
            if ($allSpeakerEntries[0]['is_approved']) {
                return $this
                    ->response
                    ->setJSON(['error' => 'USER_ALREADY_IS_SPEAKER'])
                    ->setStatusCode(ResponseInterface::HTTP_FORBIDDEN);
            }
            return $this
                ->response
                ->setJSON(['error' => 'USER_ALREADY_HAS_PENDING_APPLICATION'])
                ->setStatusCode(ResponseInterface::HTTP_FORBIDDEN);
        }

        return $latestPublishedEvent;
    }
}
