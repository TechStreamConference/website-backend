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

    public function getTags(): ResponseInterface {
        $model = model(TagModel::class);
        return $this->response->setJSON($model->getAll());
    }

    public function getTalkDurationChoices(): ResponseInterface
    {
        $model = model(TalkDurationChoiceModel::class);
        return $this->response->setJSON($model->getAll());
    }
}
