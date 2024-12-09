<?php

namespace App\Models;

use App\Helpers\Role;
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

    public function hasRole(int $userId, Role $role): bool
    {
        $roles = $this->getByUserId($userId);
        if ($roles === null) {
            return false;
        }
        return match ($role) {
            Role::ADMIN => $roles['is_admin'],
            Role::SPEAKER => $roles['is_speaker'],
            Role::TEAM_MEMBER => $roles['is_team_member'],
            default => false,
        };
    }
}
