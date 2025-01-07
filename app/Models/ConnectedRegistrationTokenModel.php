<?php

namespace App\Models;

use CodeIgniter\Model;

class ConnectedRegistrationTokenModel extends Model
{
    protected $table = 'ConnectedRegistrationToken';
    protected $allowedFields = [
        'user_id',
        'token',
    ];
    protected $useTimestamps = true;
    protected array $casts = [
        'user_id' => 'int',
    ];

    public function get(string $token): ?array
    {
        return $this->where('token', $token)->first();
    }

    public function deleteToken(string $token): void
    {
        $this->where('token', $token)->delete();
    }
}
