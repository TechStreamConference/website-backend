<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GlobalsModel;

class AdminDashboard extends BaseController
{
    public function setGlobals() {
        $data = $this->request->getJSON(assoc: true);

        $rules = [
            'default_year' => 'integer|greater_than[2023]',
            'footer_text' => 'string',
        ];

        if (!$this->validateData($data, $rules)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }

        $validData = $this->validator->getValidated();

        $globalsModel = model(GlobalsModel::class);
        $globalsModel->write(
            $validData['default_year'],
            $validData['footer_text'],
        );
        return $this->response->setStatusCode(204);
    }
}
