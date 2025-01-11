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
            $year = intval(date('Y', strtotime($event['start_date'])));
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
