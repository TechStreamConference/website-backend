<?php

namespace App\Filters;

use App\Helpers\Role;
use App\Models\RolesModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;

class RoleAuthFilter extends AuthFilter
{
    private array $allowedRoles;

    public function __construct(Role|array $allowedRoles)
    {
        if (!is_array($allowedRoles)) {
            $allowedRoles = [$allowedRoles];
        }
        $this->allowedRoles = $allowedRoles;
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $userIdOrErrorResponse = $this->tryGetUserId();
        if ($userIdOrErrorResponse instanceof Response) {
            return $userIdOrErrorResponse;
        }
        $rolesModel = model(RolesModel::class);
        $actualRoles = $rolesModel->getByUserId($userIdOrErrorResponse);
        if ($actualRoles === null || !$this->hasExpectedRole($actualRoles)) {
            $response = Services::response();
            $response->setJSON(['error' => 'FORBIDDEN']);
            $response->setStatusCode(ResponseInterface::HTTP_FORBIDDEN);
            return $response;
        }
    }

    private function hasExpectedRole(array $actualRoles): bool
    {
        foreach ($this->allowedRoles as $allowedRole) {
            if ($this->hasRole($actualRoles, $allowedRole)) {
                return true;
            }
        }
        return false;
    }

    private function hasRole(array $actualRoles, Role $role): bool
    {
        return match ($role) {
            Role::ADMIN => $actualRoles['is_admin'],
            Role::SPEAKER => $actualRoles['is_speaker'],
            Role::TEAM_MEMBER => $actualRoles['is_team_member'],
            default => false,
        };
    }
}
