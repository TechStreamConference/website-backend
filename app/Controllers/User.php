<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        $model = model(UserModel::class);
        return $this->response->setJSON($model->getUser());
    }

    public function show(int $id)
    {
        $model = model(UserModel::class);

        $data = $model->getUser($id);

        if ($data) {
            return $this->response->setJSON($data);
        }
        return $this->response->setStatusCode(404);
    }
}
