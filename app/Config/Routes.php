<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\User;

/**
 * @var RouteCollection $routes
 */
$routes->get('user', [User::class, 'index']);
$routes->get('user/(:num)', [User::class, 'show/$1']);
