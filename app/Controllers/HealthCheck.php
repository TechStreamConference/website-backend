<?php

namespace App\Controllers;

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
