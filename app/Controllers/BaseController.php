<?php

namespace App\Controllers;

use App\Models\GuestModel;
use App\Models\SpeakerModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    /** This function returns the ID of the currently logged in user. We don't check their role here.
     * @return int The ID of the currently logged in user.
     */
    protected function getLoggedInUserId(): int
    {
        $session = session();
        if (!$session->has('user_id')) {
            throw new RuntimeException("User is not logged in.");
        }
        return $session->get('user_id');
    }

    protected function addGuestsToTalks(array &$talks, array $speakers): void
    {
        $talkIds = array_column($talks, 'id');
        if (empty($talkIds)) {
            return;
        }

        $speakerModel = model(SpeakerModel::class);
        $eventIds = array_unique(array_column($talks, 'event_id'));
        $speakersByEvent = [];
        foreach ($eventIds as $eventId) {
            $speakersByEvent[$eventId] = $speakerModel->getApproved($eventId);
        }

        $guestModel = model(GuestModel::class);
        $guests = $guestModel->getGuestsOfTalks($talkIds);
        $guestIdsByTalkId = [];
        foreach ($guests as $guest) {
            $guestIdsByTalkId[$guest['talk_id']][] = $guest['user_id'];
        }

        foreach ($talks as &$talk) {
            // Find the speaker for this talk based on their user_id.
            $talk['speaker_id'] = null;
            unset($speaker);
            foreach ($speakers as $speaker) {
                if ($speaker['user_id'] === $talk['user_id']) {
                    $talk['speaker_id'] = $speaker['id'];
                    break;
                }
            }

            $guestsForThisTalk = array_map(
                function ($guestId) use ($speakersByEvent, $talk) {
                    foreach ($speakersByEvent[$talk['event_id']] as $speaker) {
                        if ($speaker['user_id'] === $guestId) {
                            return $speaker;
                        }
                    }
                    return null;
                },
                $guestIdsByTalkId[$talk['id']] ?? []
            );
            usort($guestsForThisTalk, fn($a, $b) => $a['name'] <=> $b['name']);
            $talk['guests'] = $guestsForThisTalk;
        }

        $talks = array_filter(
            $talks,
            fn($talk) => $talk['speaker_id'] !== null
        );
    }
}
