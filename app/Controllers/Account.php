<?php

namespace App\Controllers;

use App\Helpers\EmailHelper;
use App\Models\AccountModel;
use App\Models\RolesModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use App\Models\VerificationTokenModel;

class Account extends BaseController
{
    const VERIFICATION_RULES = [
        'token' => 'required|trim',
    ];

    public function register()
    {
        $this->deleteExpiredAccounts();

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
            // Username or email already taken.
            $userModel->deleteUser($userId);
            return $this->response->setJSON(['error' => 'USERNAME_OR_EMAIL_ALREADY_TAKEN'])->setStatusCode(400);
        }

        $validationToken = $this->storeValidationToken($userId);
        if ($validationToken === null) {
            // This could only happen if the token is already in use. So, this should never happen.
            // But if it does, we need to clean up the database.
            $accountModel->deleteAccount($userId);
            $userModel->deleteUser($userId);
            return $this->response->setStatusCode(500);
        }

        // Base URL is something that ends with /api/, so we need to remove api/ from the base URL.
        $baseUrl = base_url();
        $suffix = "api/";
        if (str_ends_with($baseUrl, $suffix)) {
            $baseUrl = substr($baseUrl, 0, -strlen($suffix));
        }

        $verificationLink = $baseUrl . 'verify-email-address' . '?token=' . $validationToken;

        EmailHelper::sendToAdmins(
            'Neues Benutzerkonto',
            view('email/admin/new_user', ['username' => $username])
        );

        EmailHelper::send(
            $email,
            'Deine Registrierung bei der Tech Stream Conference',
            view(
                'email/account/verify_email_address',
                [
                    'username' => $username,
                    'verificationLink' => $verificationLink,
                ]
            )
        );

        return $this->response->setJSON(['message' => 'success'])->setStatusCode(201);
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
            // Username/email or password missing.
            return $this->response->setJSON(['error' => 'USERNAME_OR_EMAIL_FIELD_MISSING'])->setStatusCode(400);
        }

        $model = model(AccountModel::class);
        $account = $model->getAccountByUsernameOrEmail($usernameOrEmail);
        if ($account === null || $account['is_verified'] === false) {
            // Unknown username or email.
            return $this->response->setJSON(['error' => 'UNKNOWN_USERNAME_OR_EMAIL'])->setStatusCode(404);
        }

        if (!password_verify($password, $account['password'])) {
            return $this->response->setJSON(['error' => 'WRONG_PASSWORD'])->setStatusCode(401);
        }

        $session = session();
        $sessionData = [
            'user_id' => $account['user_id'],
        ];
        $session->set($sessionData);

        return $this->response->setJSON(['login' => 'success'])->setStatusCode(200);
    }

    public function verify()
    {
        $data = $this->request->getJSON(assoc: true);

        if (!$this->validateData($data, self::VERIFICATION_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }

        $validData = $this->validator->getValidated();
        $token = $validData['token'];

        $verificationTokenModel = model(VerificationTokenModel::class);
        $entry = $verificationTokenModel->get($token);
        $notFoundJsonData = ['error' => 'TOKEN_NOT_FOUND'];
        if ($entry === null) {
            return $this->response->setJSON($notFoundJsonData)->setStatusCode(404);
        }

        $verificationTokenModel->deleteToken($token);

        if ($entry['expires_at'] < date('Y-m-d H:i:s')) {
            return $this->response->setJSON($notFoundJsonData)->setStatusCode(404);
        }

        $accountModel = model(AccountModel::class);
        $accountModel->markAsVerified($entry['user_id']);

        return $this->response->setJSON(['message' => 'success']);
    }

    public function logout()
    {
        $session = session();
        $session->remove('user_id');
        $session->destroy();
        return $this->response->setJSON(['logout' => 'success']);
    }

    private function storeValidationToken(int $userId): string|null
    {
        $token = bin2hex(random_bytes(64));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 day'));
        $model = model(VerificationTokenModel::class);
        if (!$model->store($token, $userId, $expiresAt)) {
            // This could only happen if the token is already in use, but this is
            // very unlikely because the token is generated randomly.
            return null;
        }
        return $token;
    }

    private function deleteExpiredAccounts()
    {
        $accountModel = model(AccountModel::class);
        $userModel = model(UserModel::class);
        $verificationTokenModel = model(VerificationTokenModel::class);
        $expiredTokens = $verificationTokenModel->getExpiredTokens();
        foreach ($expiredTokens as $expiredToken) {
            $verificationTokenModel->deleteToken($expiredToken['token']);
            $accountModel->deleteAccount($expiredToken['user_id']);
            $userModel->deleteUser($expiredToken['user_id']);
        }
    }
}
