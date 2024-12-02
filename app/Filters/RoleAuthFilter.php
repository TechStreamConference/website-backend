<?php

namespace App\Filters;

use App\Helpers\Role;
use App\Models\RolesModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\Response;

class RoleAuthFilter extends AuthFilter
{
    private Role $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $userIdOrErrorResponse = $this->tryGetUserId();
        if ($userIdOrErrorResponse instanceof Response) {
            return $userIdOrErrorResponse;
        }
        $rolesModel = model(RolesModel::class);
        $roles = $rolesModel->getByUserId($userIdOrErrorResponse);
        if ($roles === null || !$this->hasExpectedRole($roles)) {
            $response = Services::response();
            $response->setJSON(['error' => 'Forbidden']);
            $response->setStatusCode(403);
            return $response;
        }
    }

    private function hasExpectedRole(array $roles): bool
    {
        return match ($this->role) {
            Role::ADMIN => $roles['is_admin'],
            Role::SPEAKER => $roles['is_speaker'],
            Role::TEAM_MEMBER => $roles['is_team_member'],
            default => false,
        };
    }
}
