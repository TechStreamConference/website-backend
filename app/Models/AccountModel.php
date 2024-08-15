<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table = 'Account';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['email', 'username', 'password', 'password_change_required'];
    protected $useAutoIncrement = false;
    protected $useTimestamps = true;

    public function isUsernameTaken(string $username): bool
    {
        return $this->where(['username' => $username])->countAllResults() > 0;
    }

    public function isEmailTaken(string $email): bool
    {
        return $this->where(['email' => $email])->countAllResults() > 0;
    }

    public function createAccount(int $user_id, string $username, string $password_hash, string $email): bool
    {
        try {
            $this->insert([
                'user_id' => $user_id,
                'username' => $username,
                'password' => $password_hash,
                'email' => $email,
            ]);
            return true;
        } catch (\ReflectionException) {
            return false;
        }
    }

    public function createUserAndAccount(string $username, string $password_hash, string $email): int|false
    {
        $this->db->transStart();
        $user_id = model(UserModel::class)->createUser();
        $this->insert([
            'user_id' => $user_id,
            'username' => $username,
            'password' => $password_hash,
            'email' => $email,
        ]);
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            return false;
        }
        return $user_id;
    }
}
