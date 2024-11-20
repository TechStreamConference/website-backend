<?php

use App\Controllers\Account;
use App\Controllers\AdminDashboard;
use App\Controllers\Event;
use App\Controllers\Globals;
use App\Controllers\Image;
use App\Controllers\HealthCheck;
use App\Filters\AdminAuthFilter;
use App\Filters\AuthFilter;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('account/username/exists', [Account::class, 'usernameExists']);
$routes->get('account/email/exists', [Account::class, 'emailExists']);
$routes->get('account/roles', [Account::class, 'roles'], ['filter' => AuthFilter::class]);
$routes->post('account/register', [Account::class, 'register']);
$routes->post('account/login', [Account::class, 'login']);
$routes->post('account/logout', [Account::class, 'logout']);
$routes->get('images/(:segment)', [Image::class, 'get']);
$routes->get('events', [Event::class, 'get']);
$routes->get('events/(:num)', [Event::class, 'get']);
$routes->get('events/(:num)/ics', [Event::class, 'getICalendarFile']);
$routes->get('health', [HealthCheck::class, 'check']);
$routes->get('globals', [Globals::class, 'get']);
$routes->put('dashboard/admin/globals', [AdminDashboard::class, 'setGlobals'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/all-events', [AdminDashboard::class, 'getAllEvents'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/event/(:num)', [AdminDashboard::class, 'updateEvent'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/event/(:num)/speaker', [AdminDashboard::class, 'getEventSpeakers'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/event/(:num)/speaker', [AdminDashboard::class, 'updateSpeakerDates'], ['filter' => AdminAuthFilter::class]);
$routes->post('dashboard/admin/event/new', [AdminDashboard::class, 'createEvent'], ['filter' => AdminAuthFilter::class]);
