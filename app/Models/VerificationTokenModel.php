<?php

namespace App\Models;

use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Model;

class VerificationTokenModel extends Model
{
    protected $table = 'VerificationToken';
    protected $allowedFields = [
        'user_id',
        'token',
        'expires_at',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
    protected array $casts = [
        'user_id' => 'int',
    ];

    public function get(string $token): array|null
    {
        return $this
            ->where('token', $token)
            ->first();
    }

    public function store(string $token, int $userId, string $expiresAt): bool
    {
        try {
            $this->insert([
                'token' => $token,
                'user_id' => $userId,
                'expires_at' => $expiresAt,
            ]);
            return true;
        } catch (DatabaseException) {
            return false;
        }
    }

    public function deleteToken(string $token): void
    {
        $this->where('token', $token)->delete();
    }

    public function getExpiredTokens(): array
    {
        return $this
            ->where('expires_at <', date('Y-m-d H:i:s'))
            ->findAll();
    }
}
