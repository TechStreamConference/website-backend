<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GlobalsModel;

class AdminDashboard extends BaseController
{
    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');
        if ($userId === null) {
            // should never happen since the route is guarded by the AuthFilter
            // todo: This is not easily testable since we cannot get around the AuthFilter.
            //       https://codeigniter4.github.io/CodeIgniter4/testing/controllers.html describes how to test
            //       controllers but the needed trait clashes with the FeatureTestCase trait.
            return $this->response->setStatusCode(401);
        }
        $globalsModel = model(GlobalsModel::class);
        $globals = $globalsModel->read();
        if ($globals === null) {
            // the global settings are faulty
            return $this->response->setStatusCode(500);
        }
        return $this->response->setJSON($globals);
    }

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
