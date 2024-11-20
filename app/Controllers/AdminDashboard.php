<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\GlobalsModel;
use App\Models\SpeakerModel;

class AdminDashboard extends BaseController
{
    public function setGlobals()
    {
        $data = $this->request->getJSON(assoc: true);

        $rules = [
            'footer_text' => 'string',
        ];

        if (!$this->validateData($data, $rules)) {
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
    ];

    public function createEvent()
    {
        $data = $this->request->getJSON(assoc: true);

        if (!$this->validateData($data, self::EVENT_RULES)) {
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

        if (!$this->validateData($data, self::EVENT_RULES)) {
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
            return $this->response->setJSON(['error' => 'Event with given id not found.'])->setStatusCode(404);
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
                return $this->response->setJSON([
                    'error' => 'Speaker with given id not found in the list of approved speakers for the event.'
                ])->setStatusCode(404);
            }
        }

        foreach ($data as $speaker) {
            $row = $speakers[array_search($speaker['id'], array_column($speakers, 'id'))];
            $row['visible_from'] = $speaker['visible_from'];
            $speakerModel->update($speaker['id'], $row);
        }
        $this->response->setStatusCode(204);
    }
}
