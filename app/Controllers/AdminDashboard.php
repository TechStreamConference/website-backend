<?php

namespace App\Controllers;

use App\Helpers\EmailHelper;
use App\Helpers\VideoLinkType;
use App\Helpers\VideoRoomHelper;
use App\Helpers\VideoSourceType;
use App\Models\AccountModel;
use App\Models\EventModel;
use App\Models\GlobalsModel;
use App\Models\GuestModel;
use App\Models\SocialMediaTypeModel;
use App\Models\SpeakerModel;
use App\Models\TalkModel;
use App\Models\VideoRoomModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminDashboard extends BaseController
{
    private const CREATE_SOCIAL_MEDIA_LINK_RULES = [
        'name' => 'required|string|max_length[100]',
    ];

    private const CREATE_VIDEO_ROOM_RULES = [
        'base_url' => 'required|string|max_length[256]',
    ];

    public function setGlobals(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);

        $rules = [
            'footer_text' => 'string',
        ];

        if (!$this->validateData($data ?? [], $rules)) {
            return $this
                ->response
                ->setJSON($this->validator->getErrors())
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $validData = $this->validator->getValidated();

        $globalsModel = model(GlobalsModel::class);
        $globalsModel->write(
            $validData['footer_text'],
        );
        return $this
            ->response
            ->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
    }

    private const EVENT_RULES = [
        'title' => 'string|max_length[100]',
        'subtitle' => 'string|max_length[200]',
        'start_date' => 'valid_date[Y-m-d]',
        'end_date' => 'valid_date[Y-m-d]',
        'discord_url' => 'permit_empty|string|max_length[200]',
        'twitch_url' => 'permit_empty|string|max_length[200]',
        'presskit_url' => 'permit_empty|string|max_length[200]',
        'trailer_youtube_id' => 'permit_empty|string|max_length[200]',
        'description_headline' => 'string|max_length[200]',
        'description' => 'string',
        'schedule_visible_from' => 'permit_empty|valid_date[Y-m-d H:i:s]',
        'publish_date' => 'permit_empty|valid_date[Y-m-d H:i:s]',
        'call_for_papers_start' => 'permit_empty|valid_date[Y-m-d H:i:s]',
        'call_for_papers_end' => 'permit_empty|valid_date[Y-m-d H:i:s]',
    ];

    public function createEvent(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);

        if (!$this->validateData($data ?? [], self::EVENT_RULES)) {
            return $this
                ->response
                ->setJSON($this->validator->getErrors())
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $validData = $this->validator->getValidated();

        $eventModel = model(EventModel::class);
        $eventModel->createEvent(
            $validData['title'],
            $validData['subtitle'],
            $validData['start_date'],
            $validData['end_date'],
            $validData['discord_url'] ?? null,
            $validData['twitch_url'] ?? null,
            $validData['presskit_url'] ?? null,
            $validData['trailer_youtube_id'] ?? null,
            $validData['description_headline'],
            $validData['description'],
            $validData['schedule_visible_from'] ?? null,
            $validData['publish_date'] ?? null,
            $validData['call_for_papers_start'] ?? null,
            $validData['call_for_papers_end'] ?? null,
        );

        return $this
            ->response
            ->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    public function updateEvent(int $eventId): ResponseInterface
    {
        $eventModel = model(EventModel::class);
        $event = $eventModel->get($eventId);
        if ($event === null) {
            return $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        /* It's a bit dangerous to assume that the event will still be present a few
           lines below, because in theory another request could have deleted it in the meantime.
           But since we do not allow deleting events, we can ignore this problem for now. */

        $data = $this->request->getJSON(assoc: true);

        if (!$this->validateData($data ?? [], self::EVENT_RULES)) {
            return $this
                ->response
                ->setJSON($this->validator->getErrors())
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $validData = $this->validator->getValidated();

        $eventModel->updateEvent(
            $eventId,
            $validData['title'],
            $validData['subtitle'],
            $validData['start_date'],
            $validData['end_date'],
            $validData['discord_url'] ?? null,
            $validData['twitch_url'] ?? null,
            $validData['presskit_url'] ?? null,
            $validData['trailer_youtube_id'] ?? null,
            $validData['description_headline'],
            $validData['description'],
            $validData['schedule_visible_from'] ?? null,
            $validData['publish_date'] ?? null,
            $validData['call_for_papers_start'] ?? null,
            $validData['call_for_papers_end'] ?? null,
        );

        return $this
            ->response
            ->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
    }

    public function getAllEvents(): ResponseInterface
    {
        $eventModel = model(EventModel::class);
        $events = $eventModel->getAll();
        return $this->response->setJSON($events);
    }

    public function getEventSpeakers(int $eventId): ResponseInterface
    {
        $eventModel = model(EventModel::class);
        $events = $eventModel->getAll();
        if (!in_array($eventId, array_column($events, 'id'), true)) {
            return $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $speakerModel = model(SpeakerModel::class);
        $speakers = $speakerModel->getApproved($eventId);
        return $this->response->setJSON($speakers);
    }

    public function updateSpeakerDates(int $eventId): ResponseInterface
    {
        $eventModel = model(EventModel::class);
        $events = $eventModel->getAll();
        if (!in_array($eventId, array_column($events, 'id'))) {
            // Event with given id not found.
            return $this
                ->response
                ->setJSON(['error' => 'EVENT_NOT_FOUND'])
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $speakerModel = model(SpeakerModel::class);
        $speakers = $speakerModel->getApproved($eventId);

        $data = $this->request->getJSON(assoc: true);
        $rules = [
            'id' => 'required|integer',
            'visible_from' => 'valid_date[Y-m-d H:i:s]',
        ];
        foreach ($data as $speaker) {
            if (!$this->validateData($speaker, $rules)) {
                return $this
                    ->response
                    ->setJSON($this->validator->getErrors())
                    ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
            }
            if (!in_array($speaker['id'], array_column($speakers, 'id'))) {
                // Speaker with given id not found in the list of approved speakers for the event.
                return $this
                    ->response
                    ->setJSON(['error' => 'SPEAKER_NOT_AMONG_APPROVED_SPEAKERS_OF_EVENT'])
                    ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            }
        }

        foreach ($data as $speaker) {
            $row = $speakers[array_search($speaker['id'], array_column($speakers, 'id'))];
            $row['visible_from'] = $speaker['visible_from'];
            $speakerModel->update($speaker['id'], $row);
        }
        return $this
            ->response
            ->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
    }

    public function createSocialMediaType(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::CREATE_SOCIAL_MEDIA_LINK_RULES)) {
            return $this
                ->response
                ->setJSON($this->validator->getErrors())
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        $validData = $this->validator->getValidated();

        $model = model(SocialMediaTypeModel::class);

        $linkTypes = $model->all();
        foreach ($linkTypes as $linkType) {
            if ($linkType['name'] === $validData['name']) {
                // Social media link type already exists.
                return $this
                    ->response
                    ->setJSON(['error' => 'SOCIAL_MEDIA_LINK_TYPE_ALREADY_EXISTS'])
                    ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
            }
        }

        $model->create($validData['name']);
        return $this
            ->response
            ->setJSON(['message' => 'SOCIAL_MEDIA_LINK_TYPE_CREATED'])
            ->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    public function createOrUpdateVideoRoom(int $eventId): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::CREATE_VIDEO_ROOM_RULES)) {
            return $this
                ->response
                ->setJSON($this->validator->getErrors())
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        $validData = $this->validator->getValidated();

        $eventModel = model(EventModel::class);
        $events = $eventModel->get($eventId);
        if ($events === null) {
            return $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $model = model(VideoRoomModel::class);
        $baseUrl = $validData['base_url'];
        if (!str_ends_with($baseUrl, '/')) {
            $baseUrl .= '/';
        }
        $roomId = VideoRoomHelper::randomString(30); // Less than 31 characters, otherwise vdo.ninja will trim it.
        $password = VideoRoomHelper::randomString(50);
        $model->createOrUpdate(
            eventId: $eventId,
            baseUrl: $baseUrl,
            roomId: $roomId,
            password: $password
        );
        return $this
            ->response
            ->setJSON(['message' => 'VIDEO_ROOM_CREATED'])
            ->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    public function getVideoRoom(int $eventId): ResponseInterface
    {
        $eventModel = model(EventModel::class);
        $events = $eventModel->get($eventId);
        if ($events === null) {
            return $this
                ->response
                ->setJSON(['error' => 'EVENT_NOT_FOUND'])
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $model = model(VideoRoomModel::class);
        $room = $model->get($eventId);
        if ($room === null) {
            return $this
                ->response
                ->setJSON(['error' => 'VIDEO_ROOM_DOES_NOT_EXIST'])
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        $baseUrl = $room['base_url'];
        $roomId = $room['room_id'];
        $password = $room['password'];
        $isRoomVisible = ($room['visible_from'] !== null && date($room['visible_from']) <= date('Y-m-d H:i:s'));

        $userIds = $this->gatherUserIdsForVideoRoom($eventId);

        $speakerModel = model(SpeakerModel::class);
        $speakers = [];
        foreach ($userIds as $userId) {
            $speakers[$userId] = $speakerModel->getLatestApprovedForEvent($userId, $eventId);
        }

        usort($speakers, function ($a, $b) {
            return $a['name'] <=> $b['name'];
        });

        $speakerLinks = [];
        foreach ($speakers as $speaker) {
            $links = ['name' => $speaker['name']];
            foreach (VideoLinkType::cases() as $linkType) {
                foreach (VideoSourceType::cases() as $sourceType) {
                    $links["{$linkType->value}_{$sourceType->value}"] =
                        VideoRoomHelper::createVideoLink(
                            $baseUrl,
                            $roomId,
                            $password,
                            $eventId,
                            $speaker['user_id'],
                            $speaker['name'],
                            $linkType,
                            $sourceType
                        );

                }
            }
            $speakerLinks[] = $links;
        }

        $result = [
            'is_visible' => $isRoomVisible,
            'director' => $this->createDirectorLink($baseUrl, $roomId, $password),
            'speakers' => $speakerLinks,
        ];

        return $this->response->setJSON($result);
    }

    public function setVideoRoomVisible(int $eventId): ResponseInterface
    {
        $eventModel = model(EventModel::class);
        $event = $eventModel->get($eventId);
        if ($event === null) {
            return $this
                ->response
                ->setJSON(['error' => 'EVENT_NOT_FOUND'])
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $videoRoomModel = model(VideoRoomModel::class);
        if ($videoRoomModel->get($eventId) === null) {
            return $this
                ->response
                ->setJSON(['error' => 'VIDEO_ROOM_DOES_NOT_EXIST'])
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $userIds = $this->gatherUserIdsForVideoRoom($eventId);

        $accountModel = model(AccountModel::class);
        $accounts = $accountModel->getAccounts($userIds);

        // TODO: Decide whether this should be checked or not. If it is checked,
        //       then the data of 2024 won't work.
        /*if (count($accounts) != count($userIds)) {
            return $this
                ->response
                ->setJSON(['error' => 'ACCOUNT_NOT_FOUND'])
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }*/

        if (!$videoRoomModel->setVisibleFrom($eventId, date('Y-m-d H:i:s'))) {
            return $this
                ->response
                ->setJSON(['error' => 'SETTING_VISIBLE_FROM_FAILED'])
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        $failed = false;
        $numMailsSent = 0;
        foreach ($accounts as $account) {
            if (!EmailHelper::send(
                to: $account['email'],
                subject: "Deine Einwahldaten für die {$event['title']}",
                message: view(
                    'email/contributor/video_room',
                    [
                        'event_title' => $event['title'],
                        'username' => $account['username'],
                    ]
                )
            )) {
                $failed = true;
            } else {
                ++$numMailsSent;
            }
        }

        if ($failed) {
            return $this
                ->response
                ->setJSON([
                    'error' => 'EMAIL_SENDING_FAILED',
                    'num_mails_sent' => $numMailsSent,
                    'num_accounts' => count($accounts),
                    'num_users' => count($userIds),
                ])
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this
            ->response
            ->setJSON([
                'num_mails_sent' => $numMailsSent,
                'num_accounts' => count($accounts),
                'num_users' => count($userIds),
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    private function createDirectorLink(string $baseUrl, string $roomId, string $password): string
    {
        return "{$baseUrl}?room={$roomId}&password={$password}&director";
    }

    private function gatherUserIdsForVideoRoom(int $eventId): array
    {
        $talkModel = model(TalkModel::class);
        $acceptedTalks = $talkModel->getAllWithAcceptedTimeSlot($eventId);

        $guestModel = model(GuestModel::class);
        $guests = $guestModel->getGuestsOfTalks(array_column($acceptedTalks, 'id'));

        return array_unique(
            array_merge(
                array_column($acceptedTalks, 'user_id'),
                array_column($guests, 'user_id')
            )
        );
    }
}
