<?php

namespace App\Filters;

use CodeIgniter\Config\Services;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $userIdOrErrorResponse = $this->tryGetUserId();
        if ($userIdOrErrorResponse instanceof Response) {
            return $userIdOrErrorResponse;
        }
    }

    protected function tryGetUserId(): Response|int {
        $session = session();
        $userId = $session->get('user_id');
        if ($userId === null) {
            $response = Services::response();
            $response->setJSON(['error' => 'NOT_LOGGED_IN']);
            $response->setStatusCode(401);
            return $response;
        }
        return $userId;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
