<?php

use App\Controllers\Account;
use App\Controllers\AdminDashboard;
use App\Controllers\Approval;
use App\Controllers\Event;
use App\Controllers\Globals;
use App\Controllers\Image;
use App\Controllers\HealthCheck;
use App\Controllers\UserDashboard;
use App\Controllers\SpeakerDashboard;
use App\Controllers\TeamMemberDashboard;
use App\Filters\AdminAuthFilter;
use App\Filters\AuthFilter;
use App\Filters\SpeakerAuthFilter;
use App\Filters\TeamMemberAuthFilter;
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
$routes->post('account/verify', [Account::class, 'verify']);
$routes->get('images/(:segment)', [Image::class, 'get']);
$routes->get('events', [Event::class, 'get']);
$routes->get('events/(:num)', [Event::class, 'get']);
$routes->get('events/(:num)/ics', [Event::class, 'getICalendarFile']);
$routes->get('health', [HealthCheck::class, 'check']);
$routes->get('globals', [Globals::class, 'get']);
$routes->get('social-media-link-types', [Globals::class, 'getSocialMediaLinkTypes']);

$routes->put('dashboard/admin/globals', [AdminDashboard::class, 'setGlobals'], ['filter' => AdminAuthFilter::class]);
$routes->post('dashboard/admin/social-media-link-type', [AdminDashboard::class, 'createSocialMediaType'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/all-events', [AdminDashboard::class, 'getAllEvents'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/event/(:num)', [AdminDashboard::class, 'updateEvent'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/event/(:num)/speaker', [AdminDashboard::class, 'getEventSpeakers'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/event/(:num)/speaker', [AdminDashboard::class, 'updateSpeakerDates'], ['filter' => AdminAuthFilter::class]);
$routes->post('dashboard/admin/event/new', [AdminDashboard::class, 'createEvent'], ['filter' => AdminAuthFilter::class]);

$routes->get('dashboard/admin/approval/speaker', [Approval::class, 'getPendingSpeakers'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/approval/team-member', [Approval::class, 'getPendingTeamMembers'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/approval/speaker/(:num)', [Approval::class, 'approveSpeaker'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/approval/team-member/(:num)', [Approval::class, 'approveTeamMember'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/approval/speaker/(:num)/request-changes', [Approval::class, 'requestChangesForSpeaker'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/approval/team-member/(:num)/request-changes', [Approval::class, 'requestChangesForTeamMember'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/approval/social-media-link', [Approval::class, 'getPendingSocialMediaLinks'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/approval/social-media-link/(:num)', [Approval::class, 'approveSocialMediaLink'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/approval/social-media-link/(:num)/request-changes', [Approval::class, 'requestChangesForSocialMediaLink'], ['filter' => AdminAuthFilter::class]);

$routes->get('dashboard/speaker/all-events', [SpeakerDashboard::class, 'getAll'], ['filter' => SpeakerAuthFilter::class]);
$routes->get('dashboard/speaker/event/(:num)', [SpeakerDashboard::class, 'get'], ['filter' => SpeakerAuthFilter::class]);
$routes->post('dashboard/speaker/event/(:num)', [SpeakerDashboard::class, 'createOrUpdate'], ['filter' => SpeakerAuthFilter::class]);

$routes->get('dashboard/team-member/all-events', [TeamMemberDashboard::class, 'getAll'], ['filter' => TeamMemberAuthFilter::class]);
$routes->get('dashboard/team-member/event/(:num)', [TeamMemberDashboard::class, 'get'], ['filter' => TeamMemberAuthFilter::class]);
$routes->post('dashboard/team-member/event/(:num)', [TeamMemberDashboard::class, 'createOrUpdate'], ['filter' => TeamMemberAuthFilter::class]);

$routes->get('dashboard/user/social-media-link', [UserDashboard::class, 'get'], ['filter' => 'SpeakerOrTeamMemberAuthFilter']);
$routes->post('dashboard/user/social-media-link', [UserDashboard::class, 'create'], ['filter' => 'SpeakerOrTeamMemberAuthFilter']);
$routes->put('dashboard/user/social-media-link', [UserDashboard::class, 'update'], ['filter' => 'SpeakerOrTeamMemberAuthFilter']);
$routes->delete('dashboard/user/social-media-link/(:num)', [UserDashboard::class, 'delete'], ['filter' => 'SpeakerOrTeamMemberAuthFilter']);
// Speaker application logic resides in the SpeakerDashboard controller, even though it is accessed by the UserDashboard.
// The main reason for this is to be able to reuse the code.
$routes->post('dashboard/user/apply-as-speaker', [SpeakerDashboard::class, 'applyAsSpeaker'], ['filter' => AuthFilter::class]);
$routes->get('dashboard/user/get-application-event', [SpeakerDashboard::class, 'getApplicationEvent'], ['filter' => AuthFilter::class]);

$routes->get('test', [Account::class, 'mailTest']);
