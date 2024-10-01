<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\SpeakerModel;

class HealthCheck extends BaseController
{
    public function check() {
        return $this->response->setJSON([
            'up' => true,
        ]);
    }
}
