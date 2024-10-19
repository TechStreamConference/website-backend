<?php

namespace App\Filters;

use App\Models\RolesModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\Response;

class AdminAuthFilter extends AuthFilter
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $userIdOrErrorResponse = $this->tryGetUserId();
        if ($userIdOrErrorResponse instanceof Response) {
            return $userIdOrErrorResponse;
        }
        $rolesModel = model(RolesModel::class);
        $roles = $rolesModel->getByUserId($userIdOrErrorResponse);
        if ($roles === null || !$roles['is_admin']) {
            $response = Services::response();
            $response->setJSON(['error' => 'Forbidden']);
            $response->setStatusCode(403);
            return $response;
        }
    }
}
