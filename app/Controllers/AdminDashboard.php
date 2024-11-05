<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\GlobalsModel;

class AdminDashboard extends BaseController
{
    public function setGlobals() {
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

    public function getAllEvents() {
        $eventModel = model(EventModel::class);
        $events = $eventModel->getAll();
        return $this->response->setJSON($events);
    }
}
