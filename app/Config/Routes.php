<?php

use App\Controllers\Account;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\User;

/**
 * @var RouteCollection $routes
 */
$routes->get('user', [User::class, 'index']);
$routes->get('user/(:num)', [User::class, 'show/$1']);
$routes->post('register', [Account::class, 'register']);
$routes->post('login', [Account::class, 'login']);
$routes->get('account/username/exists', [Account::class, 'usernameExists']);
$routes->get('account/email/exists', [Account::class, 'emailExists']);
