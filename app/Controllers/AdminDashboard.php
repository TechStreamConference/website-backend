<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\GlobalsModel;
use App\Models\SocialMediaTypeModel;
use App\Models\SpeakerModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminDashboard extends BaseController
{
    private const CREATE_SOCIAL_MEDIA_LINK_RULES = [
        'name' => 'required|string|max_length[100]',
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
        'frontpage_date' => 'permit_empty|valid_date[Y-m-d H:i:s]',
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
            title: $validData['title'],
            subtitle: $validData['subtitle'],
            startDate: $validData['start_date'],
            endDate: $validData['end_date'],
            discordUrl: $validData['discord_url'] ?? null,
            twitchUrl: $validData['twitch_url'] ?? null,
            presskitUrl: $validData['presskit_url'] ?? null,
            trailerYoutubeId: $validData['trailer_youtube_id'] ?? null,
            descriptionHeadline: $validData['description_headline'],
            description: $validData['description'],
            scheduleVisibleFrom: $validData['schedule_visible_from'] ?? null,
            publishDate: $validData['publish_date'] ?? null,
            frontpageDate: $validData['frontpage_date'] ?? null,
            callForPapersStart: $validData['call_for_papers_start'] ?? null,
            callForPapersEnd: $validData['call_for_papers_end'] ?? null,
        );

        return $this
            ->response
            ->setJSON(['message' => 'EVENT_CREATED'])
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
            eventId: $eventId,
            title: $validData['title'],
            subtitle: $validData['subtitle'],
            startDate: $validData['start_date'],
            endDate: $validData['end_date'],
            discordUrl: $validData['discord_url'] ?? null,
            twitchUrl: $validData['twitch_url'] ?? null,
            presskitUrl: $validData['presskit_url'] ?? null,
            trailerYoutubeId: $validData['trailer_youtube_id'] ?? null,
            descriptionHeadline: $validData['description_headline'],
            description: $validData['description'],
            scheduleVisibleFrom: $validData['schedule_visible_from'] ?? null,
            publishDate: $validData['publish_date'] ?? null,
            frontpageDate: $validData['frontpage_date'] ?? null,
            callForPapersStart: $validData['call_for_papers_start'] ?? null,
            callForPapersEnd: $validData['call_for_papers_end'] ?? null,
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
            ->setJSON(['message' => 'New social media link type created.'])
            ->setStatusCode(ResponseInterface::HTTP_CREATED);
    }
}
