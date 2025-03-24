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
        'new_email',
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

    public function store(
        string  $token,
        int     $userId,
        string  $expiresAt,
        ?string $newEmail,
    ): bool
    {
        try {
            $this->insert([
                'token' => $token,
                'user_id' => $userId,
                'expires_at' => $expiresAt,
                'new_email' => $newEmail,
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

    public function deleteTokens(array $tokens): void
    {
        if (empty($tokens)) {
            return;
        }
        $this->whereIn('token', $tokens)->delete();
    }

    public function getExpiredTokens(): array
    {
        return $this
            ->where('expires_at <', date('Y-m-d H:i:s'))
            ->findAll();
    }
}
