<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CreationThrottle implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        if (ENVIRONMENT === 'testing') {
            return; // Skip throttling in tests
        }
        $throttler = service('throttler');
        // We require the IP address to be in the `X-Real-IP` header.
        $ip = $request->header('x-real-ip')->getValue();
        if ($throttler->check(md5("creation-throttle-$ip"), 3, HOUR) === false) {
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
