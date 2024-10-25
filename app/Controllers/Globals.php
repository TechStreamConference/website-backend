<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\GlobalsModel;

class Globals extends BaseController
{
    public function get()
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
        $events = $eventModel->getAll();
        $yearsWithEvents = [];
        foreach ($events as $event) {
            $year = intval(date('Y', strtotime($event['start_date'])));
            $yearsWithEvents[] = $year;
        }
        $globals['years_with_events'] = $yearsWithEvents;

        return $this->response->setJSON($globals);
    }
}
