<?php

use App\Controllers\Account;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('register', [Account::class, 'register']);
$routes->post('login', [Account::class, 'login']);
$routes->get('account/username/exists', [Account::class, 'usernameExists']);
$routes->get('account/email/exists', [Account::class, 'emailExists']);
