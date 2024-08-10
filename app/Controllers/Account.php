<?php

namespace App\Controllers;

use App\Models\AccountModel;

class Account extends BaseController
{
    public function register()
    {
        $model = model(AccountModel::class);

        $data = $this->request->getJSON();
        $username = trim($data->username);
        $password_hash = password_hash($data->password, PASSWORD_DEFAULT);
        $email = trim($data->email);

        $user_id = $model->createUserAndAccount($username, $password_hash, $email);
        if ($user_id === false) {
            return $this->response->setStatusCode(400);
        }
        return $this->response->setStatusCode(201);
    }

    public function usernameExists()
    {
        $model = model(AccountModel::class);
        $username = $this->request->getGet('username');
        if ($model->isUsernameTaken($username)) {
            return $this->response->setStatusCode(200);
        }
        return $this->response->setStatusCode(204);
    }

    public function emailExists()
    {
        $model = model(AccountModel::class);
        $email = $this->request->getGet('email');
        if ($model->isEmailTaken($email)) {
            return $this->response->setStatusCode(200);
        }
        return $this->response->setStatusCode(204);
    }

    public function login()
    {
        // todo
        return 'Login';
    }
}
