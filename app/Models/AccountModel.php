<?php

namespace App\Models;

use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table = 'Account';
    protected $primaryKey = 'user_id';
    // according to the docs, the primary key should never be part of the allowedFields
    // array, but it doesn't seem to work without having it in there (the reason could be
    // that it is also a foreign key)
    protected $allowedFields = ['user_id', 'email', 'username', 'password', 'password_change_required'];
    protected $useTimestamps = true;

    public function isUsernameTaken(string $username): bool
    {
        return $this->where(['username' => $username])->countAllResults() > 0;
    }

    public function isEmailTaken(string $email): bool
    {
        return $this->where(['email' => $email])->countAllResults() > 0;
    }

    public function createAccount(int $userId, string $username, string $passwordHash, string $email): bool
    {
        try {
            $this->insert([
                'user_id' => $userId,
                'username' => $username,
                'password' => $passwordHash,
                'email' => $email,
            ]);
            return true;
        } catch (DatabaseException) {
            return false;
        }
    }

    public function getAccountByUsernameOrEmail(string $usernameOrEmail): array|null
    {
        return $this->where('username', $usernameOrEmail)->orWhere('email', $usernameOrEmail)->first();
    }

    public function get(int $userId): array|null
    {
        return $this->select('username, email')->where('user_id', $userId)->first();
    }
}
