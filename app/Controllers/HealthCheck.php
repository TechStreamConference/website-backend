<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\SpeakerModel;
use CodeIgniter\HTTP\ResponseInterface;

class HealthCheck extends BaseController
{
    public function check(): ResponseInterface
    {
        return $this->response->setJSON([
            'up' => true,
        ]);
    }
}
