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
    protected $allowedFields = [
        'user_id',
        'email',
        'is_verified',
        'username',
        'password_change_required'
    ];
    protected array $casts = [
        'user_id' => 'int',
        'is_verified' => 'bool',
        'password_change_required' => 'bool',
    ];
    protected $useTimestamps = true;

    public function isUsernameTaken(string $username): bool
    {
        return $this
                ->where(['username' => $username])
                ->countAllResults() > 0;
    }

    public function isEmailTaken(string $email): bool
    {
        return $this
                ->where(['email' => $email])
                ->countAllResults() > 0;
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

    public function markAsVerified(int $userId): void
    {
        $this->update($userId, ['is_verified' => true]);
    }

    public function deleteAccount(int $userId): void
    {
        $this->where('user_id', $userId)->delete();
    }

    public function getAccountByUsernameOrEmail(string $usernameOrEmail): array|null
    {
        return $this
            ->where('username', $usernameOrEmail)
            ->orWhere('email', $usernameOrEmail)
            ->first();
    }

    public function get(int $userId): array|null
    {
        return $this
            ->select('username, email')
            ->where('user_id', $userId)
            ->first();
    }

    public function checkPassword(int $userId, string $password): bool
    {
        $account = $this->find($userId);
        return password_verify($password, $account['password']);
    }

    public function getAdmins(): array
    {
        return $this
            ->select('Account.user_id, username, email')
            ->join('Admin', 'Admin.user_id = Account.user_id')
            ->findAll();
    }

    public function changePassword(int $userId, string $newPassword): void
    {
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->update($userId, ['password' => $newPasswordHash]);
    }

    public function changeUsername(int $userId, string $newUsername): void
    {
        $this->update($userId, ['username' => $newUsername]);
    }
}
