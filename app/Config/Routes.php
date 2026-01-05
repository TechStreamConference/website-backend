<?php

use App\Controllers\Account;
use App\Controllers\AdminDashboard;
use App\Controllers\Approval;
use App\Controllers\Contact;
use App\Controllers\Event;
use App\Controllers\Globals;
use App\Controllers\Image;
use App\Controllers\HealthCheck;
use App\Controllers\SpeakerDashboard;
use App\Controllers\Talk;
use App\Controllers\TeamMemberDashboard;
use App\Controllers\TimeSlot;
use App\Filters\AdminAuthFilter;
use App\Filters\AuthFilter;
use App\Filters\CreationThrottle;
use App\Filters\SpeakerAuthFilter;
use App\Filters\SpeakerOrTeamMemberAuthFilter;
use App\Filters\TeamMemberAuthFilter;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('contact', [Contact::class, 'send']);
$routes->get('account/username/exists', [Account::class, 'usernameExists']);
$routes->get('account/email/exists', [Account::class, 'emailExists']);
$routes->get('account/roles', [Account::class, 'roles'], ['filter' => AuthFilter::class]);
$routes->post('account/register', [Account::class, 'register'], ['filter' => CreationThrottle::class]);
$routes->post('account/forgot-password', [Account::class, 'forgotPassword']);
$routes->post('account/reset-password', [Account::class, 'resetPassword']);
$routes->post('account/login', [Account::class, 'login']);
$routes->post('account/logout', [Account::class, 'logout']);
$routes->post('account/verify', [Account::class, 'verify']);
$routes->put('account/change-username', [Account::class, 'changeUsername'], ['filter' => AuthFilter::class]);
$routes->put('account/change-password', [Account::class, 'changePassword'], ['filter' => AuthFilter::class]);
$routes->put('account/change-email', [Account::class, 'changeEmail'], ['filter' => AuthFilter::class]);
$routes->get('images/(:segment)', [Image::class, 'get']);
$routes->get('events', [Event::class, 'get']);
$routes->get('events/(:num)', [Event::class, 'get']);
$routes->get('events/(:num)/ics', [Event::class, 'getICalendarFile']);
$routes->get('health', [HealthCheck::class, 'check']);
$routes->get('globals', [Globals::class, 'get']);
$routes->get('social-media-link-types', [Globals::class, 'getSocialMediaLinkTypes']);
$routes->get('tags', [Globals::class, 'getTags']);
$routes->put('tags', [Globals::class, 'updateTags'], ['filter' => AdminAuthFilter::class]);
$routes->post('tags', [Globals::class, 'createTags'], ['filter' => AdminAuthFilter::class]);
$routes->get('talk-duration-choices', [Globals::class, 'getTalkDurationChoices']);
$routes->post('talk-duration-choices', [Globals::class, 'addTalkDurationChoices'], ['filter' => AdminAuthFilter::class]);

$routes->put('dashboard/admin/globals', [AdminDashboard::class, 'setGlobals'], ['filter' => AdminAuthFilter::class]);
$routes->post('dashboard/admin/social-media-link-type', [AdminDashboard::class, 'createSocialMediaType'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/all-events', [AdminDashboard::class, 'getAllEvents'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/event/(:num)', [AdminDashboard::class, 'updateEvent'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/event/(:num)/speaker', [AdminDashboard::class, 'getEventSpeakers'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/event/(:num)/speaker', [AdminDashboard::class, 'updateSpeakerDates'], ['filter' => AdminAuthFilter::class]);
$routes->post('dashboard/admin/event/new', [AdminDashboard::class, 'createEvent'], ['filter' => AdminAuthFilter::class]);

$routes->get('dashboard/admin/approval/speaker', [Approval::class, 'getPendingSpeakers'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/approval/user/(:num)/event/(:num)/can-reject', [Approval::class, 'canReject'], ['filter' => AdminAuthFilter::class]);
$routes->delete('dashboard/admin/approval/user/(:num)/event/(:num)/reject', [Approval::class, 'reject'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/approval/team-member', [Approval::class, 'getPendingTeamMembers'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/approval/speaker/(:num)', [Approval::class, 'approveSpeaker'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/approval/team-member/(:num)', [Approval::class, 'approveTeamMember'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/approval/speaker/(:num)/request-changes', [Approval::class, 'requestChangesForSpeaker'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/approval/team-member/(:num)/request-changes', [Approval::class, 'requestChangesForTeamMember'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/approval/social-media-link', [Approval::class, 'getPendingSocialMediaLinks'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/approval/social-media-link/(:num)', [Approval::class, 'approveSocialMediaLink'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/approval/social-media-link/(:num)/request-changes', [Approval::class, 'requestChangesForSocialMediaLink'], ['filter' => AdminAuthFilter::class]);

$routes->post('dashboard/admin/talk/create', [Talk::class, 'create'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/talk/possible-hosts/(:num)', [Talk::class, 'getPossibleHosts'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/talk/(:num)/possible-guests', [Talk::class, 'getPossibleGuests'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/talk/(:num)/set-guests', [Talk::class, 'setGuests'], ['filter' => AdminAuthFilter::class]);
$routes->delete('dashboard/admin/talk/(:num)/remove-all-guests', [Talk::class, 'removeAllGuests'], ['filter' => AdminAuthFilter::class]);

$routes->get('dashboard/admin/time-slots/(:num)', [TimeSlot::class, 'get'], ['filter' => AdminAuthFilter::class]);
$routes->post('dashboard/admin/time-slots/(:num)', [TimeSlot::class, 'create_or_replace'], ['filter' => AdminAuthFilter::class]);

$routes->get('dashboard/speaker/all-events', [SpeakerDashboard::class, 'getAllPublished'], ['filter' => SpeakerAuthFilter::class]);
$routes->get('dashboard/speaker/event/(:num)', [SpeakerDashboard::class, 'getIfPublished'], ['filter' => SpeakerAuthFilter::class]);
$routes->post('dashboard/speaker/event/(:num)', [SpeakerDashboard::class, 'createOrUpdateIfPublished'], ['filter' => SpeakerAuthFilter::class]);
$routes->post('dashboard/speaker/copy-latest-approved-speaker-entry', [SpeakerDashboard::class, 'copyLatestApprovedSpeakerEntry'], ['filter' => SpeakerAuthFilter::class]);

// For better organization, the following routes are defined in the Talk controller.
$routes->get('dashboard/speaker/can-submit-talk', [Talk::class, 'canSubmit'], ['filter' => SpeakerAuthFilter::class]);
$routes->post('dashboard/speaker/submit-talk', [Talk::class, 'submit'], ['filter' => SpeakerAuthFilter::class]);
$routes->put('dashboard/speaker/talk/(:num)', [Talk::class, 'change'], ['filter' => SpeakerAuthFilter::class]);
$routes->put('dashboard/speaker/talk/(:num)/accept-time-slot', [Talk::class, 'acceptTimeSlot'], ['filter' => SpeakerAuthFilter::class]);
$routes->put('dashboard/speaker/talk/(:num)/reject-time-slot', [Talk::class, 'rejectTimeSlot'], ['filter' => SpeakerAuthFilter::class]);
$routes->get('dashboard/speaker/pending-talks', [Talk::class, 'getPendingTalksForSpeaker'], ['filter' => SpeakerAuthFilter::class]);
$routes->get('dashboard/speaker/tentative-or-accepted-talks/(:num)', [Talk::class, 'getTentativeOrAcceptedTalksForSpeaker'], ['filter' => SpeakerAuthFilter::class]);
$routes->get('dashboard/admin/pending-talks', [Talk::class, 'getAllPendingTalks'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/tentative-talks', [Talk::class, 'getAllTentativeTalks'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/tentative-or-accepted-talks/(:num)', [Talk::class, 'getTentativeOrAcceptedTalksForEvent'], ['filter' => AdminAuthFilter::class]);
$routes->post('dashboard/admin/talk/(:num)/request-changes', [Talk::class, 'requestChanges'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/talk/(:num)/approve', [Talk::class, 'approve'], ['filter' => AdminAuthFilter::class]);
$routes->post('dashboard/admin/talk/(:num)/reject', [Talk::class, 'reject'], ['filter' => AdminAuthFilter::class]);
$routes->put('dashboard/admin/talk/(:num)/suggest-time-slot', [Talk::class, 'suggestTimeSlot'], ['filter' => AdminAuthFilter::class]);

$routes->get('dashboard/team-member/all-events', [TeamMemberDashboard::class, 'getAll'], ['filter' => TeamMemberAuthFilter::class]);
$routes->get('dashboard/team-member/event/(:num)', [TeamMemberDashboard::class, 'get'], ['filter' => TeamMemberAuthFilter::class]);
$routes->post('dashboard/team-member/event/(:num)', [TeamMemberDashboard::class, 'createOrUpdate'], ['filter' => TeamMemberAuthFilter::class]);

// The social media link logic resides in the abstract base class ContributorDashboard. Since that class cannot be
// instantiated, we use the TeamMemberDashboard class here instead.
$routes->get('dashboard/user/social-media-link', [TeamMemberDashboard::class, 'getLatestSocialMediaLinksForCurrentUser'], ['filter' => SpeakerOrTeamMemberAuthFilter::class]);
$routes->post('dashboard/user/social-media-link', [TeamMemberDashboard::class, 'createSocialMediaLinkForCurrentUser'], ['filter' => SpeakerOrTeamMemberAuthFilter::class]);
$routes->put('dashboard/user/social-media-link', [TeamMemberDashboard::class, 'updateSocialMediaLinksForCurrentUser'], ['filter' => SpeakerOrTeamMemberAuthFilter::class]);
$routes->delete('dashboard/user/social-media-link/(:num)', [TeamMemberDashboard::class, 'deleteSocialMediaLink'], ['filter' => SpeakerOrTeamMemberAuthFilter::class]);
// Speaker application logic resides in the SpeakerDashboard controller, even though it is accessed by the UserDashboard.
// The main reason for this is to be able to reuse the code.
$routes->post('dashboard/user/apply-as-speaker', [SpeakerDashboard::class, 'applyAsSpeaker'], ['filter' => AuthFilter::class]);
$routes->get('dashboard/user/get-application-event', [SpeakerDashboard::class, 'getApplicationEvent'], ['filter' => AuthFilter::class]);

$routes->post('dashboard/admin/video-room/event/(:num)', [AdminDashboard::class, 'createOrUpdateVideoRoom'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/admin/video-room/event/(:num)', [AdminDashboard::class, 'getVideoRoom'], ['filter' => AdminAuthFilter::class]);
$routes->post('dashboard/admin/video-room/event/(:num)/set-visible', [AdminDashboard::class, 'setVideoRoomVisible'], ['filter' => AdminAuthFilter::class]);
$routes->get('dashboard/speaker/video-room/exists', [SpeakerDashboard::class, 'videoRoomExists'], ['filter' => SpeakerAuthFilter::class]);
$routes->get('dashboard/speaker/video-room', [SpeakerDashboard::class, 'getVideoRoom'], ['filter' => SpeakerAuthFilter::class]);
