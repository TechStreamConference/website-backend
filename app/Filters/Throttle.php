<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Throttle implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $throttler = service('throttler');
        // We require the IP address to be in the `X-Real-IP` header.
        $ip = $request->header('x-real-ip')->getValue();
        error_log("Throttle: $ip");
        if ($throttler->check(md5($ip), 10, SECOND) === false) {
            return service('response')
                ->setStatusCode(429)
                ->setJSON([
                    'error' => 'TOO_MANY_REQUESTS',
                    'retry_after' => $throttler->getTokentime(),
                ])
                ->setHeader('Retry-After', $throttler->getTokentime());
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
