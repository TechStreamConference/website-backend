<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GlobalsModel;

class Globals extends BaseController
{
    public function get()
    {
        $globalsModel = model(GlobalsModel::class);
        $globals = $globalsModel->read();
        if ($globals === null) {
            // the global settings are faulty
            return $this->response->setStatusCode(500);
        }
        return $this->response->setJSON($globals);
    }
}
