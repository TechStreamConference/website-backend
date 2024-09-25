<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\SpeakerModel;

class Event extends BaseController
{
    public function get(int|null $year = null) {
        if ($year === null) {
            // todo: fetch the currently displayed year from the database
            $year = 2024;
        }
        $eventModel = new EventModel();
        $event = $eventModel->getByYear($year);
        if ($event === null) {
            return $this->response->setStatusCode(404);
        }

        $speakerModel = new SpeakerModel();
        $speakers = $speakerModel->getPublished($event['id']);

        return $this->response->setJSON([
            'year' => $year,
            'event' => $event,
            'speakers' => $speakers,
        ]);
    }
}
