<?php

use App\Controllers\Account;
use App\Controllers\Event;
use App\Controllers\Image;
use App\Controllers\HealthCheck;
use App\Filters\AuthFilter;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('account/username/exists', [Account::class, 'usernameExists']);
$routes->get('account/email/exists', [Account::class, 'emailExists']);
$routes->get('account/roles', [Account::class, 'roles']);
$routes->post('account/register', [Account::class, 'register']);
$routes->post('account/login', [Account::class, 'login']);
$routes->post('account/logout', [Account::class, 'logout']);
$routes->get('account', [Account::class, 'get'], ['filter' => AuthFilter::class]);
$routes->get('images/(:segment)', [Image::class, 'get']);
$routes->get('events/(:num)', [Event::class, 'get']);
$routes->get('events', [Event::class, 'get']);
$routes->get('health', [HealthCheck::class, 'check']);
