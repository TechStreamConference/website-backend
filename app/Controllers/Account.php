<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\UserModel;

class Account extends BaseController
{
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
        $userId = $this->request->getGet('user_id');
        if (empty($userId)) {
            return $this->response->setStatusCode(400);
        }
        $userModel = model(UserModel::class);
        $roles = $userModel->getRoles($userId);
        if ($roles === null) {
            // user does not exist
            return $this->response->setStatusCode(404);
        }
        return $this->response->setJSON($roles)->setStatusCode(200);
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

    public function get()
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

        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($userId);
        if ($account === null) {
            // should never happen since the session data should never contain a user_id that does not exist
            return $this->response->setStatusCode(500);
        }
        return $this->response->setJSON($account);
    }
}
