<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\GlobalsModel;
use App\Models\SocialMediaTypeModel;
use App\Models\TagModel;
use App\Models\TalkDurationChoiceModel;
use CodeIgniter\HTTP\ResponseInterface;

class Globals extends BaseController
{
    const TALK_DURATION_CHOICES_RULES = [
        'choices.*' => 'required|is_natural_no_zero',
    ];

    const UPDATE_TAGS_RULES = [
        'tags.*.id' => 'required|is_natural_no_zero',
        'tags.*.text' => 'required|string|max_length[255]',
        'tags.*.color_index' => 'required|is_natural_no_zero',
    ];

    const CREATE_TAGS_RULES = [
        'tags.*.text' => 'required|string|max_length[255]',
        'tags.*.color_index' => 'required|is_natural_no_zero',
    ];

    public function get(): ResponseInterface
    {
        // get global settings
        $globalsModel = model(GlobalsModel::class);
        $globals = $globalsModel->read();
        if ($globals === null) {
            // the global settings are faulty
            return $this->response->setStatusCode(500);
        }

        // get all years with events
        $eventModel = model(EventModel::class);
        $events = $eventModel->getAllPublished();
        $yearsWithEvents = [];
        foreach ($events as $event) {
            $year = (int)date('Y', strtotime($event['start_date']));
            $yearsWithEvents[] = $year;
        }
        $globals['years_with_events'] = $yearsWithEvents;

        return $this->response->setJSON($globals);
    }

    public function getSocialMediaLinkTypes(): ResponseInterface
    {
        $model = model(SocialMediaTypeModel::class);
        return $this->response->setJSON($model->all());
    }

    public function getTags(): ResponseInterface
    {
        $model = model(TagModel::class);
        return $this->response->setJSON($model->getAll());
    }

    public function updateTags(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::UPDATE_TAGS_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $model = model(TagModel::class);
        $existingTags = $model->getAll();

        foreach ($validData['tags'] as $tag) {
            if (!in_array($tag['id'], array_column($existingTags, 'id'))) {
                return $this->response->setJSON(['error' => 'TAG_DOES_NOT_EXIST'])->setStatusCode(400);
            }
        }

        foreach ($validData['tags'] as $tag) {
            $model->change(id: $tag['id'], text: $tag['text'], colorIndex: $tag['color_index']);
        }

        return $this->response->setJSON(['message' => 'TAGS_UPDATED']);
    }

    public function createTags(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::CREATE_TAGS_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $model = model(TagModel::class);
        $existingTags = $model->getAll();

        foreach ($validData['tags'] as $tag) {
            if (in_array($tag['text'], array_column($existingTags, 'text'))) {
                return $this->response->setJSON(['error' => 'TAG_ALREADY_EXISTS'])->setStatusCode(400);
            }
        }

        foreach ($validData['tags'] as $tag) {
            $model->createTag(text: $tag['text'], colorIndex: $tag['color_index']);
        }

        return $this->response->setJSON(['message' => 'TAGS_CREATED'])->setStatusCode(201);
    }

    public function getTalkDurationChoices(): ResponseInterface
    {
        $model = model(TalkDurationChoiceModel::class);
        return $this->response->setJSON($model->getAll());
    }

    public function addTalkDurationChoices(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::TALK_DURATION_CHOICES_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $model = model(TalkDurationChoiceModel::class);
        $existingChoices = $model->getAll();
        $numAdded = 0;
        foreach ($validData['choices'] as $choice) {
            if (!in_array($choice, $existingChoices)) {
                $model->add($choice);
                ++$numAdded;
            }
        }

        return $this->response->setJSON(['message' => "ADDED_{$numAdded}_CHOICES"])->setStatusCode(201);
    }
}
