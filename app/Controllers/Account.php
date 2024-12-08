<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\RolesModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Account extends BaseController
{
    public function mailTest(): ResponseInterface {
        $email = Services::email();

        $email->setTo('john@doe.com');
        $email->setSubject('Test email');
        $email->setMessage('This is a test email');

        if ($email->send()) {
            return $this->response->setJSON(['mail' => 'sent']);
        } else {
            return $this->response->setJSON(['mail' => 'not sent']);
        }
    }

    public function register()
    {
        $accountModel = model(AccountModel::class);
        $userModel = model(UserModel::class);

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
        $passwordHash = password_hash($validData['password'], PASSWORD_DEFAULT);
        $email = $validData['email'];

        $userId = $userModel->createUser();
        if ($accountModel->createAccount($userId, $username, $passwordHash, $email) === false) {
            $userModel->deleteUser($userId);
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

    public function roles()
    {
        $session = session();
        $userId = $session->get('user_id');
        $rolesModel = model(RolesModel::class);
        $roles = $rolesModel->getByUserId($userId);
        if ($roles === null) {
            // There cannot be an account without the possibility to query the roles.
            // This would only be possible for a user that has no account, but then
            // this user wouldn't be able to log in.
            return $this->response->setStatusCode(500);
        }
        return $this->response->setJSON($roles);
    }

    public function login()
    {
        $usernameOrEmail = trim($this->request->getJsonVar('username_or_email'));
        $password = $this->request->getJsonVar('password');

        if (empty($usernameOrEmail) || empty($password)) {
            return $this->response->setJSON(['error' => 'Username/email or password missing'])->setStatusCode(400);
        }

        $model = model(AccountModel::class);
        $account = $model->getAccountByUsernameOrEmail($usernameOrEmail);
        if ($account === null) {
            return $this->response->setJSON(['error' => 'Unknown username or email'])->setStatusCode(404);
        }

        if (!password_verify($password, $account['password'])) {
            return $this->response->setJSON(['error' => 'Invalid password'])->setStatusCode(401);
        }

        $session = session();
        $sessionData = [
            'user_id' => $account['user_id'],
        ];
        $session->set($sessionData);

        return $this->response->setJSON(['login' => 'success'])->setStatusCode(200);
    }

    public function logout()
    {
        $session = session();
        $session->remove('user_id');
        $session->destroy();
        return $this->response->setJSON(['logout' => 'success']);
    }
}
