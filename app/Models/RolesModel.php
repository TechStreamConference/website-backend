<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesModel extends Model
{
    protected $table = 'Roles';
    protected $allowedFields = ['user_id', 'email', 'username', 'is_speaker', 'is_team_member', 'is_admin'];
    protected $useTimestamps = true;
    protected array $casts = [
        'user_id' => 'int',
        'is_speaker' => 'bool',
        'is_team_member' => 'bool',
        'is_admin' => 'bool',
    ];

    public function getByUserId(int $userId): object|array|null
    {
        return $this->where('user_id', $userId)->first();
    }
}
