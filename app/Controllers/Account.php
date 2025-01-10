<?php

namespace App\Controllers;

use App\Helpers\EmailHelper;
use App\Models\AccountModel;
use App\Models\ConnectedRegistrationTokenModel;
use App\Models\PasswordResetTokenModel;
use App\Models\RolesModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use App\Models\VerificationTokenModel;
use Random\RandomException;

class Account extends BaseController
{
    const USERNAME_RULE = 'required|trim|alpha_dash|min_length[3]|max_length[30]';
    const PASSWORD_RULE = 'required|valid_password';
    const EMAIL_RULE = 'required|trim|valid_email|max_length[320]';

    const REGISTER_RULES = [
        'username' => self::USERNAME_RULE,
        'password' => self::PASSWORD_RULE,
        'email' => self::EMAIL_RULE,
        'token' => 'permit_empty|trim|alpha_numeric|max_length[128]',
    ];

    const VERIFICATION_RULES = [
        'token' => 'required|trim|alpha_numeric|max_length[128]',
    ];

    const FORGOT_PASSWORD_RULES = [
        'username_or_email' => 'required|max_length[320]',
    ];

    const RESET_PASSWORD_RULES = [
        'token' => 'required|trim',
        'new_password' => self::PASSWORD_RULE,
    ];

    const CHANGE_USERNAME_RULES = [
        'username' => self::USERNAME_RULE,
        'password' => self::PASSWORD_RULE,
    ];

    public function register()
    {
        $this->deleteExpiredAccounts();

        $accountModel = model(AccountModel::class);
        $userModel = model(UserModel::class);

        $data = $this->request->getJSON(assoc: true);

        if (!$this->validateData($data ?? [], self::REGISTER_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }

        $validData = $this->validator->getValidated();
        $username = $validData['username'];
        $passwordHash = password_hash($validData['password'], PASSWORD_DEFAULT);
        $email = $validData['email'];

        // If a token was provided, we won't create a new user during this registration, but
        // instead connect the new account to an existing user. This is used for speakers
        // that have already been created by the admins, before the site goes live.
        $token = $validData['token'] ?? null;
        $isConnectedRegistration = $token !== null;
        if (!$isConnectedRegistration) {
            $userId = $userModel->createUser();
        } else {
            // Check which user the provided token belongs to.
            $connectedRegistrationTokenModel = model(ConnectedRegistrationTokenModel::class);
            $entry = $connectedRegistrationTokenModel->get($token);
            if ($entry === null) {
                return $this->response->setJSON(['error' => 'TOKEN_NOT_FOUND'])->setStatusCode(404);
            }
            $userId = $entry['user_id'];
            // We will delete the token further down, after everything else was successful.
        }

        if ($accountModel->createAccount($userId, $username, $passwordHash, $email) === false) {
            // Username or email already taken.
            if (!$isConnectedRegistration) {
                $userModel->deleteUser($userId);
            }
            return $this->response->setJSON(['error' => 'USERNAME_OR_EMAIL_ALREADY_TAKEN'])->setStatusCode(400);
        }

        $validationToken = $this->storeValidationToken($userId);
        if ($validationToken === null) {
            // This could only happen if the token is already in use, or if the random generator
            // fails. So, this should never happen. But if it does, we need to clean up the database.
            $accountModel->deleteAccount($userId);
            if (!$isConnectedRegistration) {
                $userModel->deleteUser($userId);
            }
            return $this->response->setStatusCode(500);
        }

        // Base URL is something that ends with /api/, so we need to remove api/ from the base URL.
        $baseUrl = base_url();
        $suffix = "api/";
        if (str_ends_with($baseUrl, $suffix)) {
            $baseUrl = substr($baseUrl, 0, -strlen($suffix));
        }

        $verificationLink = $baseUrl . 'verify-email-address' . '?token=' . $validationToken;

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

        if ($isConnectedRegistration) {
            $connectedRegistrationTokenModel->deleteToken($token);
        }

        return $this->response->setJSON(['message' => 'success'])->setStatusCode(201);
    }

    /**
     * Sends an email to the user with a link to reset the password.
     * @return ResponseInterface The response.
     */
    public function forgotPassword(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);

        if (!$this->validateData($data ?? [], self::FORGOT_PASSWORD_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }

        $validData = $this->validator->getValidated();
        $username_or_email = $validData['username_or_email'];

        $accountModel = model(AccountModel::class);
        $account = $accountModel->getAccountByUsernameOrEmail($username_or_email);
        if ($account === null) {
            // We could "pretend" that the email was sent successfully, but it wouldn't be reasonable,
            // because it's possible to find out if an email address is registered or not, anyway. So
            // this wouldn't give us any security advantage, but it would make the user experience worse.
            return $this->response->setJSON(['error' => 'UNKNOWN_USERNAME_OR_EMAIL'])->setStatusCode(404);
        }

        // Create a password reset token. It is possible that there are multiple reset tokens for the
        // same user. They all remain valid until they expire. But when a user uses any of those tokens
        // to reset their password, all other tokens are deleted (see the resetPassword method).
        $passwordResetTokenModel = model(PasswordResetTokenModel::class);
        try {
            $token = bin2hex(random_bytes(64));
        } catch (RandomException) {
            return $this->response->setStatusCode(500);
        }
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 day'));
        $passwordResetTokenModel->store($token, $account['user_id'], $expiresAt);

        // Base URL is something that ends with /api/, so we need to remove api/ from the base URL.
        $baseUrl = base_url();
        $suffix = "api/";
        if (str_ends_with($baseUrl, $suffix)) {
            $baseUrl = substr($baseUrl, 0, -strlen($suffix));
        }

        $resetPasswordLink = $baseUrl . 'reset-password' . '?token=' . $token;

        // We could avoid including the username in the email, because at first glance
        // a hacker who has control over the email account, could find out the username.
        // But after the hacker has reset the password, they could find out the username
        // anyway, because they could log in.
        EmailHelper::send(
            $account['email'],
            'Passwort zurücksetzen',
            view(
                'email/account/forgot_password',
                [
                    'username' => $account['username'],
                    'resetPasswordLink' => $resetPasswordLink,
                ]
            )
        );
        return $this->response->setJSON(['message' => 'success']);
    }

    /**
     * Resets the password of a user that has requested a password reset.
     * @return ResponseInterface The response.
     */
    public function resetPassword(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);

        if (!$this->validateData($data ?? [], self::RESET_PASSWORD_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }

        $validData = $this->validator->getValidated();
        $token = $validData['token'];
        $newPassword = $validData['new_password'];

        $passwordResetTokenModel = model(PasswordResetTokenModel::class);
        // Delete all expired tokens so that we don't have to check if the token is expired.
        $passwordResetTokenModel->deleteExpiredTokens();

        $entry = $passwordResetTokenModel->get($token);
        if ($entry === null) {
            return $this->response->setJSON(['error' => 'TOKEN_EXPIRED_OR_DOES_NOT_EXIST'])->setStatusCode(404);
        }

        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($entry['user_id']);
        if ($account === null) {
            // This should never happen, because the token is only created when the account exists.
            return $this->response->setStatusCode(500);
        }

        $accountModel->changePasswordHash($entry['user_id'], password_hash($newPassword, PASSWORD_DEFAULT));

        // Delete the used token as well as all other tokens of the same user that may exist.
        $passwordResetTokenModel->deleteTokensOfUser($entry['user_id']);

        EmailHelper::send(
            $account['email'],
            'Dein Passwort wurde geändert',
            view(
                'email/account/password_reset',
                [
                    'username' => $account['username'],
                ]
            )
        );

        return $this->response->setJSON(['message' => 'success']);
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
        // On each login, we delete all expired password reset tokens. There's no deeper reason  to
        // do it exactly here, but we have to do it somewhere. ¯\_(ツ)_/¯
        $passwordResetTokenModel = model(PasswordResetTokenModel::class);
        $passwordResetTokenModel->deleteExpiredTokens();

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

        if (!$this->validateData($data ?? [], self::VERIFICATION_RULES)) {
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
        $userId = $entry['user_id'];
        $account = $accountModel->get($userId);
        $username = $account['username'];
        $accountModel->markAsVerified($userId);

        EmailHelper::sendToAdmins(
            'Neues Benutzerkonto',
            view('email/admin/new_user', ['username' => $username])
        );

        return $this->response->setJSON(['message' => 'success']);
    }

    public function logout()
    {
        $session = session();
        $session->remove('user_id');
        $session->destroy();
        return $this->response->setJSON(['logout' => 'success']);
    }

    public function changeUsername(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::CHANGE_USERNAME_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }

        $validData = $this->validator->getValidated();
        $username = $validData['username'];
        $password = $validData['password'];

        $session = session();
        $userId = $session->get('user_id');
        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($userId);
        if (!password_verify($password, $account['password'])) {
            return $this->response->setJSON(['error' => 'WRONG_PASSWORD'])->setStatusCode(401);
        }

        if ($accountModel->isUsernameTaken($username)) {
            return $this->response->setJSON(['error' => 'USERNAME_ALREADY_TAKEN'])->setStatusCode(400);
        }

        $accountModel->changeUsername($userId, $username);
        return $this->response->setJSON(['message' => 'USERNAME_CHANGED']);
    }

    private function storeValidationToken(int $userId): string|null
    {
        try {
            $token = bin2hex(random_bytes(64));
        } catch (RandomException $e) {
            return null;
        }
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
