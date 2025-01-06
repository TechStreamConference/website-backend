<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetTokenModel extends Model
{
    protected $table = 'PasswordResetToken';
    protected $primaryKey = 'token';
    protected $allowedFields = ['token', 'user_id', 'expires_at'];
    protected array $casts = [
        'user_id' => 'int',
    ];
    protected $useTimestamps = true;

    public function store(string $token, int $userId, string $expiresAt): void
    {
        $this->insert([
            'token' => $token,
            'user_id' => $userId,
            'expires_at' => $expiresAt,
        ]);
    }

    public function deleteTokensOfUser(int $userId): void
    {
        $this->where('user_id', $userId)->delete();
    }

    public function deleteExpiredTokens(): void
    {
        $this->where('expires_at <', date('Y-m-d H:i:s'))->delete();
    }

    public function get(string $token): ?array
    {
        return $this->where('token', $token)->first();
    }
}
