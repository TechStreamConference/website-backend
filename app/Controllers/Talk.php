<?php

namespace App\Controllers;

use App\Helpers\EmailHelper;
use App\Models\AccountModel;
use App\Models\EventModel;
use App\Models\SpeakerModel;
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
     * given event.
     * @param int $eventId The ID of the event in question.
     * @return ResponseInterface The response to return to the client (200 if the user can
     *                           submit a talk, 403 otherwise).
     */
    public function canSubmit(int $eventId): ResponseInterface
    {
        $canSubmit = $this->canLoggedInUserSubmitTalk($eventId);
        if ($canSubmit instanceof ResponseInterface) {
            return $canSubmit;
        }
        return $this->response->setJSON(['can_submit_talk' => true])->setStatusCode(200);
    }

    public function submit(int $eventId): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data, self::TALK_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $canSubmit = $this->canLoggedInUserSubmitTalk($eventId);
        if ($canSubmit instanceof ResponseInterface) {
            return $canSubmit;
        }

        if (!$this->areDurationsValid($validData['possible_durations'])) {
            return $this->response->setJSON(['error' => 'INVALID_DURATION'])->setStatusCode(400);
        }

        $talkModel = model(TalkModel::class);
        $talkModel->create(
            eventId: $eventId,
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

    private function canLoggedInUserSubmitTalk(int $eventId): true|ResponseInterface
    {
        if (!$this->loggedInUserHasApprovedSpeakerEntry($eventId)) {
            return $this->response->setJSON(['error' => 'NO_APPROVED_SPEAKER_ENTRY'])->setStatusCode(403);
        }
        $openEventId = $this->getOpenEventId();
        if ($openEventId === null) {
            return $this->response->setJSON(['error' => 'NO_OPEN_EVENT'])->setStatusCode(403);
        }
        if ($openEventId !== $eventId) {
            return $this->response->setJSON(['error' => 'EVENT_NOT_OPEN'])->setStatusCode(403);
        }
        return true;
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
