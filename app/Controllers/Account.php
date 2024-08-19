<?php

namespace App\Controllers;

use App\Models\AccountModel;

class Account extends BaseController
{
    public function register()
    {
        $model = model(AccountModel::class);

        $data = $this->request->getJSON(assoc: true);

        $rules = [
            'username' => 'required|trim|alpha_dash|min_length[3]|max_length[30]',
            'password' => 'required|valid_password',
            'email' => 'required|trim|valid_email|max_length[320]',
        ];

        if (!$this->validateData($data, $rules)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }

        $validData = $this->validator->getValidated();
        $username = $validData['username'];
        $password_hash = password_hash($validData['password'], PASSWORD_DEFAULT);
        $email = $validData['email'];

        $user_id = $model->createUserAndAccount($username, $password_hash, $email);
        if ($user_id === false) {
            return $this->response->setJSON(['error' => 'Username or email already taken'])->setStatusCode(400);
        }
        return $this->response->setStatusCode(201);
    }

    public function usernameExists()
    {
        $model = model(AccountModel::class);
        $username = trim($this->request->getGet('username'));
        if (empty($username)) {
            return $this->response->setStatusCode(400);
        }
        return $this->response->setJSON(['exists' => $model->isUsernameTaken($username)]);
    }

    public function emailExists()
    {
        $model = model(AccountModel::class);
        $email = trim($this->request->getGet('email'));
        if (empty($email)) {
            return $this->response->setStatusCode(400);
        }
        return $this->response->setJSON(['exists' => $model->isEmailTaken($email)]);
    }

    public function login()
    {
        // todo
        return 'Login';
    }
}
