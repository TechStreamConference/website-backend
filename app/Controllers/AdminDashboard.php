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

    public function setGlobals()
    {
        $data = $this->request->getJSON(assoc: true);

        $rules = [
            'footer_text' => 'string',
        ];

        if (!$this->validateData($data ?? [], $rules)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }

        $validData = $this->validator->getValidated();

        $globalsModel = model(GlobalsModel::class);
        $globalsModel->write(
            $validData['footer_text'],
        );
        return $this->response->setStatusCode(204);
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

    public function createEvent()
    {
        $data = $this->request->getJSON(assoc: true);

        if (!$this->validateData($data ?? [], self::EVENT_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
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

        return $this->response->setStatusCode(201);
    }

    public function updateEvent(int $eventId)
    {
        $eventModel = model(EventModel::class);
        $event = $eventModel->get($eventId);
        if ($event === null) {
            return $this->response->setStatusCode(404);
        }
        /* It's a bit dangerous to assume that the event will still be present a few
           lines below, because in theory another request could have deleted it in the meantime.
           But since we do not allow deleting events, we can ignore this problem for now. */

        $data = $this->request->getJSON(assoc: true);

        if (!$this->validateData($data ?? [], self::EVENT_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
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

        return $this->response->setStatusCode(204);
    }

    public function getAllEvents()
    {
        $eventModel = model(EventModel::class);
        $events = $eventModel->getAll();
        return $this->response->setJSON($events);
    }

    public function getEventSpeakers(int $eventId)
    {
        $eventModel = model(EventModel::class);
        $events = $eventModel->getAll();
        if (!in_array($eventId, array_column($events, 'id'))) {
            return $this->response->setStatusCode(404);
        }

        $speakerModel = model(SpeakerModel::class);
        $speakers = $speakerModel->getApproved($eventId);
        return $this->response->setJSON($speakers);
    }

    public function updateSpeakerDates(int $eventId)
    {
        $eventModel = model(EventModel::class);
        $events = $eventModel->getAll();
        if (!in_array($eventId, array_column($events, 'id'))) {
            // Event with given id not found.
            return $this->response->setJSON(['error' => 'EVENT_NOT_FOUND'])->setStatusCode(404);
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
                return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
            }
            if (!in_array($speaker['id'], array_column($speakers, 'id'))) {
                // Speaker with given id not found in the list of approved speakers for the event.
                return $this
                    ->response
                    ->setJSON(['error' => 'SPEAKER_NOT_AMONG_APPROVED_SPEAKERS_OF_EVENT'])
                    ->setStatusCode(404);
            }
        }

        foreach ($data as $speaker) {
            $row = $speakers[array_search($speaker['id'], array_column($speakers, 'id'))];
            $row['visible_from'] = $speaker['visible_from'];
            $speakerModel->update($speaker['id'], $row);
        }
        $this->response->setStatusCode(204);
    }

    public function createSocialMediaType(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::CREATE_SOCIAL_MEDIA_LINK_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
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
                    ->setStatusCode(400);
            }
        }

        $model->create($validData['name']);
        return $this
            ->response
            ->setJSON(['message' => 'New social media link type created.'])
            ->setStatusCode(201);
    }
}
