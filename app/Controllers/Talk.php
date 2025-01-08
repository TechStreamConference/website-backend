<?php

namespace App\Controllers;

use App\Helpers\EmailHelper;
use App\Models\AccountModel;
use App\Models\EventModel;
use App\Models\PossibleTalkDurationModel;
use App\Models\SpeakerModel;
use App\Models\TagModel;
use App\Models\TalkDurationChoiceModel;
use App\Models\TalkModel;
use CodeIgniter\HTTP\ResponseInterface;

class Talk extends BaseController
{
    private const TALK_RULES = [
        'title' => 'required|string|max_length[255]',
        'description' => 'required|string',
        'tag_ids.*' => 'required|is_natural_no_zero',
        'possible_durations.*' => 'required|is_natural_no_zero',
        'notes' => 'permit_empty|string',
    ];

    /** Checks if the current user can submit a talk. It's not enough to have the
     * speaker role, but the user must also have an approved speaker entry for the
     * currently open event.
     * @return ResponseInterface The response to return to the client (200 if the user can
     *                           submit a talk, 403 otherwise).
     */
    public function canSubmit(): ResponseInterface
    {
        $openEventId = $this->canLoggedInUserSubmitTalk();
        if ($openEventId instanceof ResponseInterface) {
            // The user can't submit a talk.
            return $openEventId;
        }
        $eventModel = model(EventModel::class);
        $event = $eventModel->get($openEventId);
        $responseData = [
            'can_submit_talk' => true,
            'event' => $event,
        ];
        return $this->response->setJSON($responseData)->setStatusCode(200);
    }

    public function submit(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data, self::TALK_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $openEventId = $this->canLoggedInUserSubmitTalk();
        if ($openEventId instanceof ResponseInterface) {
            // The user can't submit a talk.
            return $openEventId;
        }

        // The speaker has to provide at least one possible duration for the talk (e.g. 30 minutes).
        // The possible durations have to be valid (i.e. they have to be available choices).
        if (!$this->areDurationsValid($validData['possible_durations'])) {
            return $this->response->setJSON(['error' => 'INVALID_DURATION'])->setStatusCode(400);
        }

        if (count($validData['tag_ids']) < 1) {
            return $this->response->setJSON(['error' => 'NO_TAGS'])->setStatusCode(400);
        }

        $talkModel = model(TalkModel::class);

        // Let's do a quick check to see if there's already a talk with the same title for the same event.
        // This is just to avoid problems due to people re-sending the data (e.g. by refreshing the page).
        if (count($talkModel->findAllByTitle($validData['title'], $openEventId)) > 0) {
            return $this->response->setJSON(['error' => 'DUPLICATE_TALK'])->setStatusCode(400);
        }

        $talkId = $talkModel->create(
            eventId: $openEventId,
            userId: $this->getLoggedInUserId(),
            title: $validData['title'],
            description: $validData['description'],
            notes: $validData['notes'] ?? null,
            isSpecial: false,
            requestedChanges: null,
            isApproved: false,
            timeSlotId: null,
            timeSlotAccepted: false,
        );

        $possibleTalkDurationModel = model(PossibleTalkDurationModel::class);
        $possibleTalkDurationModel->store($talkId, $validData['possible_durations']);

        $tagModel = model(TagModel::class);
        $tagModel->storeTagsForTalk($talkId, $validData['tag_ids']);

        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($this->getLoggedInUserId());
        $username = $account['username'];
        $userEmail = $account['email'];

        EmailHelper::send(
            to: $userEmail,
            subject: 'Vortragsthema eingereicht',
            message: view(
                'email/talk/talk_submitted',
                [
                    'username' => $username,
                    'title' => $validData['title'],
                ]
            )
        );

        EmailHelper::sendToAdmins(
            subject: 'Neues Vortragsthema eingereicht',
            message: view(
                'email/admin/talk_submitted',
                [
                    'username' => $username,
                    'title' => $validData['title'],
                ]
            )
        );

        return $this->response->setJSON(['success' => 'TALK_SUBMITTED'])->setStatusCode(201);
    }

    /** Checks whether the currently logged in user could submit a talk for an event.
     * @return int|ResponseInterface The ID of the event if the user can submit a talk,
     *                               a response object containing the error response otherwise.
     */
    private function canLoggedInUserSubmitTalk(): int|ResponseInterface
    {
        $openEventId = $this->getOpenEventId();
        if ($openEventId === null) {
            return $this->response->setJSON(['error' => 'NO_OPEN_EVENT'])->setStatusCode(403);
        }
        if (!$this->loggedInUserHasApprovedSpeakerEntry($openEventId)) {
            return $this->response->setJSON(['error' => 'NO_APPROVED_SPEAKER_ENTRY'])->setStatusCode(403);
        }
        return $openEventId;
    }

    private function loggedInUserHasApprovedSpeakerEntry(int $eventId): bool
    {
        $speakerModel = model(SpeakerModel::class);
        return $speakerModel->hasApprovedEntry($this->getLoggedInUserId(), $eventId);
    }

    private function getOpenEventId(): ?int
    {
        $eventModel = model(EventModel::class);
        $latestPublishedEvent = $eventModel->getLatestPublished();
        if ($latestPublishedEvent === null) {
            return null;
        }

        $currentDate = date('Y-m-d H:i:s');
        if (
            $currentDate < $latestPublishedEvent['call_for_papers_start']
            || $currentDate > $latestPublishedEvent['call_for_papers_end']
        ) {
            return null;
        }

        return $latestPublishedEvent['id'];
    }

    private function areDurationsValid(array $durations): bool
    {
        if (count($durations) < 1) {
            return false;
        }
        $talkDurationChoiceModel = model(TalkDurationChoiceModel::class);
        $availableChoices = $talkDurationChoiceModel->getAll();
        $availableDurations = array_column($availableChoices, 'duration');
        foreach ($durations as $duration) {
            if (!in_array($duration, $availableDurations, strict: true)) {
                return false;
            }
        }
        return true;
    }
}
