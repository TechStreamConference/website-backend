<?php

namespace App\Controllers;

use App\Helpers\Difference;
use App\Helpers\EmailHelper;
use App\Models\AccountModel;
use App\Models\EventModel;
use App\Models\PossibleTalkDurationModel;
use App\Models\SpeakerModel;
use App\Models\TagModel;
use App\Models\TalkDurationChoiceModel;
use App\Models\TalkModel;
use App\Models\TimeSlotModel;
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

    private const REQUEST_CHANGES_RULES = [
        'requested_changes' => 'required|string',
    ];

    private const REJECT_TALK_RULES = [
        'reason' => 'permit_empty|string',
    ];

    private const TIME_SLOT_SUGGESTION_RULES = [
        'time_slot_id' => 'required|is_natural_no_zero',
    ];

    private const REJECT_TIME_SLOT_RULES = [
        'reason' => 'permit_empty|string',
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
        if (!$this->validateData($data ?? [], self::TALK_RULES)) {
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
        $tagModel = model(TagModel::class);
        $allTags = $tagModel->getAll();
        foreach ($validData['tag_ids'] as $tagId) {
            if (!in_array($tagId, array_column($allTags, 'id'))) {
                return $this->response->setJSON(['error' => 'INVALID_TAG'])->setStatusCode(400);
            }
        }

        $talkModel = model(TalkModel::class);

        // Let's do a quick check to see if there's already a talk with the same title for the same event.
        // This is just to avoid problems due to people re-sending the data (e.g. by refreshing the page).
        if ($talkModel->doesTitleExist($validData['title'], $openEventId)) {
            return $this->response->setJSON(['error' => 'DUPLICATE_TALK'])->setStatusCode(400);
        }

        $talkId = $talkModel->create(
            eventId: $openEventId,
            userId: $this->getLoggedInUserId(),
            title: $validData['title'],
            description: $validData['description'],
            notes: $validData['notes'] ?? null,
            requestedChanges: null,
            isApproved: false,
            timeSlotId: null,
            timeSlotAccepted: false,
        );

        if ($talkId === false) {
            return $this->response->setJSON(['error' => 'TALK_CREATION_FAILED'])->setStatusCode(500);
        }

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

    public function getPendingTalksForSpeaker(): ResponseInterface
    {
        $talkModel = model(TalkModel::class);
        $pendingTalks = $talkModel->getPendingForSpeaker($this->getLoggedInUserId());

        $pendingTalks = $this->addAdditionalDataToTalks($pendingTalks);
        return $this->response->setJSON(['pending_talks' => $pendingTalks])->setStatusCode(200);
    }

    public function getTentativeOrAcceptedTalksForSpeaker(int $eventId): ResponseInterface
    {
        $talkModel = model(TalkModel::class);
        $tentativeTalks = $talkModel->getTentativeOrAcceptedForSpeaker($this->getLoggedInUserId(), $eventId);

        $tentativeTalks = $this->addAdditionalDataToTalks($tentativeTalks);
        return $this->response->setJSON(['tentative_talks' => $tentativeTalks])->setStatusCode(200);
    }

    /** Gets all pending talks of all users. A pending talk is a talk that has been submitted
     * but hasn't been approved yet. It may contain requested changes.
     * @return ResponseInterface The response to return to the client.
     * */
    public function getAllPendingTalks(): ResponseInterface
    {
        $talkModel = model(TalkModel::class);
        $pendingTalks = $talkModel->getAllPending();

        $pendingTalks = $this->addAdditionalDataToTalks($pendingTalks);
        return $this->response->setJSON(['pending_talks' => $pendingTalks])->setStatusCode(200);
    }

    public function getAllTentativeOrAcceptedTalks(int $eventId): ResponseInterface
    {
        $talkModel = model(TalkModel::class);
        $tentativeTalks = $talkModel->getAllTentativeOrAccepted($eventId);

        $tentativeTalks = $this->addAdditionalDataToTalks($tentativeTalks);
        return $this->response->setJSON(['tentative_or_accepted_talks' => $tentativeTalks])->setStatusCode(200);
    }

    public function requestChanges(int $talkId): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::REQUEST_CHANGES_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $talkModel = model(TalkModel::class);
        $talk = $talkModel->get($talkId);
        if ($talk === null) {
            return $this->response->setJSON(['error' => 'TALK_NOT_FOUND'])->setStatusCode(404);
        }
        if ($talk['is_approved']) {
            return $this->response->setJSON(['error' => 'TALK_ALREADY_APPROVED'])->setStatusCode(400);
        }
        $talkModel->requestChanges($talkId, $validData['requested_changes']);

        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($talk['user_id']);
        $username = $account['username'];
        $userEmail = $account['email'];

        $adminAccount = $accountModel->get($this->getLoggedInUserId());
        $admin = $adminAccount['username'];

        EmailHelper::send(
            to: $userEmail,
            subject: 'Dein Vortrag bei der Tech Stream Conference',
            message: view(
                'email/talk/changes_requested',
                [
                    'username' => $username,
                    'title' => $talk['title'],
                    'requested_changes' => $validData['requested_changes'],
                ]
            )
        );

        EmailHelper::sendToAdmins(
            subject: 'Änderungswünsche für Vortrag',
            message: view(
                'email/admin/changes_requested',
                [
                    'username' => $username,
                    'title' => $talk['title'],
                    'requested_changes' => $validData['requested_changes'],
                    'admin' => $admin,
                ]
            )
        );

        return $this->response->setJSON(['success' => 'CHANGES_REQUESTED'])->setStatusCode(200);
    }

    public function approve(int $talkId): ResponseInterface
    {
        $talkModel = model(TalkModel::class);
        $talk = $talkModel->get($talkId);
        if ($talk === null) {
            return $this->response->setJSON(['error' => 'TALK_NOT_FOUND'])->setStatusCode(404);
        }
        if ($talk['is_approved']) {
            return $this->response->setJSON(['error' => 'TALK_ALREADY_APPROVED'])->setStatusCode(400);
        }
        $talkModel->deleteRequestedChanges($talkId);
        $talkModel->approve($talkId);

        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($talk['user_id']);
        $username = $account['username'];
        $userEmail = $account['email'];

        $adminAccount = $accountModel->get($this->getLoggedInUserId());
        $adminUsername = $adminAccount['username'];

        EmailHelper::send(
            to: $userEmail,
            subject: 'Dein Vortrag bei der Tech Stream Conference',
            message: view(
                'email/talk/talk_approved',
                [
                    'username' => $username,
                    'title' => $talk['title'],
                ]
            )
        );

        EmailHelper::sendToAdmins(
            subject: 'Vortrag angenommen',
            message: view(
                'email/admin/talk_approved',
                [
                    'username' => $username,
                    'title' => $talk['title'],
                    'admin' => $adminUsername,
                ]
            )
        );

        return $this->response->setJSON(['success' => 'TALK_APPROVED'])->setStatusCode(200);
    }

    public function reject(int $talkId): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::REJECT_TALK_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $talkModel = model(TalkModel::class);
        $talk = $talkModel->get($talkId);
        if ($talk === null) {
            return $this->response->setJSON(['error' => 'TALK_NOT_FOUND'])->setStatusCode(404);
        }

        // We don't check whether or not the talk is already approved here, because we want to allow
        // admins to reject talks that have already been approved.

        $tagModel = model(TagModel::class);
        $tagModel->deleteAllTagsForTalk($talkId);

        $possibleDurationModel = model(PossibleTalkDurationModel::class);
        $possibleDurationModel->deleteAllForTalk($talkId);

        if (!$talkModel->delete($talkId)) {
            return $this->response->setJSON(['error' => 'TALK_DELETION_FAILED'])->setStatusCode(500);
        }

        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($talk['user_id']);
        $username = $account['username'];
        $userEmail = $account['email'];

        $adminAccount = $accountModel->get($this->getLoggedInUserId());
        $adminUsername = $adminAccount['username'];

        // Depending on whether the talk was approved before or not, we will send a different email.
        // Also, for tentative (i.e. approved) talks, we don't mention a reason for the rejection.

        if ($talk['is_approved']) {
            // Tentative talk.

            EmailHelper::send(
                to: $userEmail,
                subject: 'Dein Vortrag bei der Tech Stream Conference',
                message: view(
                    'email/talk/tentative_talk_rejected',
                    [
                        'username' => $username,
                        'title' => $talk['title'],
                    ]
                )
            );

            EmailHelper::sendToAdmins(
                subject: 'Vortrag abgelehnt',
                message: view(
                    'email/admin/tentative_talk_rejected',
                    [
                        'username' => $username,
                        'title' => $talk['title'],
                        'admin' => $adminUsername,
                    ]
                )
            );
        } else {
            // Pending talk.

            EmailHelper::send(
                to: $userEmail,
                subject: 'Dein Vortrag bei der Tech Stream Conference',
                message: view(
                    'email/talk/pending_talk_rejected',
                    [
                        'username' => $username,
                        'title' => $talk['title'],
                        'reason' => $validData['reason'] ?? null,
                    ]
                )
            );

            EmailHelper::sendToAdmins(
                subject: 'Vortrag abgelehnt',
                message: view(
                    'email/admin/pending_talk_rejected',
                    [
                        'username' => $username,
                        'title' => $talk['title'],
                        'reason' => $validData['reason'] ?? null,
                        'admin' => $adminUsername,
                    ]
                )
            );
        }

        return $this->response->setJSON(['success' => 'TALK_REJECTED'])->setStatusCode(200);
    }

    public function suggestTimeSlot(int $talkId): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::TIME_SLOT_SUGGESTION_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $talkModel = model(TalkModel::class);
        $talk = $talkModel->get($talkId);
        if ($talk === null) {
            return $this->response->setJSON(['error' => 'TALK_NOT_FOUND'])->setStatusCode(404);
        }
        if (!$talk['is_approved']) {
            return $this->response->setJSON(['error' => 'TALK_NOT_APPROVED'])->setStatusCode(400);
        }

        // We neither check whether there already is an assigned time slot for this talk, nor whether
        // the time slot is already accepted. We want to allow admins to suggest a new time slot even
        // if there already is one.

        $timeSlotModel = model(TimeSlotModel::class);
        $timeSlot = $timeSlotModel->get($validData['time_slot_id']);
        if ($timeSlot === null) {
            return $this->response->setJSON(['error' => 'TIME_SLOT_NOT_FOUND'])->setStatusCode(404);
        }

        if ($timeSlot->eventId !== $talk['event_id']) {
            return $this->response->setJSON(['error' => 'TIME_SLOT_WRONG_EVENT'])->setStatusCode(400);
        }

        if ($this->isTimeSlotOccupied($validData['time_slot_id'])) {
            return $this->response->setJSON(['error' => 'TIME_SLOT_ALREADY_OCCUPIED'])->setStatusCode(400);
        }

        $talkModel->setTimeSlot($talkId, $validData['time_slot_id']);

        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($talk['user_id']);
        $username = $account['username'];
        $email = $account['email'];
        $adminAccount = $accountModel->get($this->getLoggedInUserId());
        $adminUsername = $adminAccount['username'];

        EmailHelper::send(
            to: $email,
            subject: 'Zeitfenster für deinen Vortrag',
            message: view(
                'email/talk/time_slot_suggested',
                [
                    'username' => $username,
                    'title' => $talk['title'],
                    'timeSlot' => $timeSlot,
                ]
            )
        );

        EmailHelper::sendToAdmins(
            subject: 'Zeitfenster für Vortrag vorgeschlagen',
            message: view(
                'email/admin/time_slot_suggested',
                [
                    'admin' => $adminUsername,
                    'username' => $username,
                    'title' => $talk['title'],
                    'timeSlot' => $timeSlot,
                ]
            )
        );

        return $this->response->setJSON(['success' => 'TIME_SLOT_SUGGESTED'])->setStatusCode(200);
    }

    public function change(int $talkId): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::TALK_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $talkModel = model(TalkModel::class);
        $talk = $talkModel->get($talkId);
        if ($talk === null || $talk['user_id'] !== $this->getLoggedInUserId()) {
            return $this->response->setJSON(['error' => 'TALK_NOT_FOUND'])->setStatusCode(404);
        }

        if ($talk['is_approved']) {
            return $this->response->setJSON(['error' => 'TALK_ALREADY_APPROVED'])->setStatusCode(400);
        }

        if (count($validData['tag_ids']) < 1) {
            return $this->response->setJSON(['error' => 'NO_TAGS'])->setStatusCode(400);
        }

        if (count($validData['possible_durations']) < 1) {
            return $this->response->setJSON(['error' => 'NO_DURATIONS'])->setStatusCode(400);
        }

        $tagModel = model(TagModel::class);
        $allTags = $tagModel->getAll();
        foreach ($validData['tag_ids'] as $tagId) {
            if (!in_array($tagId, array_column($allTags, 'id'))) {
                return $this->response->setJSON(['error' => 'INVALID_TAG'])->setStatusCode(400);
            }
        }

        /** @var Difference[] $differences */
        $differences = [];
        if ($talk['title'] !== $validData['title']) {
            $differences[] = new Difference('Titel', $talk['title'], $validData['title']);
        }
        if ($talk['description'] !== $validData['description']) {
            $differences[] = new Difference('Beschreibung', $talk['description'], $validData['description']);
        }
        if ($talk['notes'] !== $validData['notes']) {
            $differences[] = new Difference('Notizen', $talk['notes'], $validData['notes']);
        }

        $possibleDurationModel = model(PossibleTalkDurationModel::class);
        $oldPossibleDurations = array_column($possibleDurationModel->get($talkId), 'duration');
        $newPossibleDurations = $validData['possible_durations'];

        sort($oldPossibleDurations);
        sort($newPossibleDurations);

        if ($oldPossibleDurations !== $newPossibleDurations) {
            $differences[] = new Difference(
                'Mögliche Dauer',
                implode(
                    ', ',
                    array_map(
                        fn($duration) => strval($duration),
                        $oldPossibleDurations
                    ),
                ),
                implode(
                    ', ',
                    array_map(
                        fn($duration) => strval($duration),
                        $newPossibleDurations,
                    )
                ),
            );
        }

        $tagMapping = $tagModel->getTagMapping([$talkId]);
        $oldTags = array_column($tagMapping[$talkId], 'text');
        $newTags = array_column($tagModel->getByIds($validData['tag_ids']), 'text');

        sort($oldTags);
        sort($newTags);

        if ($oldTags !== $newTags) {
            $differences[] = new Difference(
                'Tags',
                implode(', ', $oldTags),
                implode(', ', $newTags),
            );
        }

        if (count($differences) === 0) {
            return $this->response->setJSON(['error' => 'NO_CHANGES'])->setStatusCode(400);
        }

        $requestedChanges = $talk['requested_changes'];

        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($this->getLoggedInUserId());
        $username = $account['username'];
        $email = $account['email'];

        EmailHelper::send(
            to: $email,
            subject: 'Änderungen an deinem Vortrag',
            message: view(
                'email/talk/talk_changed',
                [
                    'username' => $username,
                    'differences' => $differences,
                ]
            )
        );

        EmailHelper::sendToAdmins(
            subject: 'Änderungen an Vortrag',
            message: view(
                'email/admin/talk_changed',
                [
                    'title' => $validData['title'],
                    'username' => $username,
                    'requested_changes' => $requestedChanges,
                    'differences' => $differences,
                ]
            )
        );

        // Instead of updating the possible talk durations and tags, we will just remove all of them
        // and re-add them immediately. This is easier and less error-prone.
        $possibleDurationModel->deleteAllForTalk($talkId);
        $tagModel->deleteAllTagsForTalk($talkId);
        if (!$talkModel->change(
            talkId: $talkId,
            eventId: $talk['event_id'],
            userId: $talk['user_id'],
            title: $validData['title'],
            description: $validData['description'],
            notes: $validData['notes'] ?? null,
            requestedChanges: null,
            isApproved: false,
            timeSlotId: null,
            timeSlotAccepted: false,
        )) {
            return $this->response->setJSON(['error' => 'TALK_CHANGE_FAILED'])->setStatusCode(500);
        }

        $possibleDurationModel->store($talkId, $validData['possible_durations']);
        $tagModel->storeTagsForTalk($talkId, $validData['tag_ids']);

        return $this->response->setJSON(['success' => 'TALK_CHANGED'])->setStatusCode(200);
    }

    public function acceptTimeSlot(int $talkId): ResponseInterface
    {
        $talk = $this->tryGetTentativeTalk($talkId);
        if ($talk instanceof ResponseInterface) {
            return $talk;
        }

        $timeSlotModel = model(TimeSlotModel::class);
        $timeSlot = $timeSlotModel->get($talk['time_slot_id']);

        $talkModel = model(TalkModel::class);
        $talkModel->acceptTimeSlot($talkId);

        $this->sendEmailToSpeaker(
            talk: $talk,
            subject: 'Zeitfenster für deinen Vortrag',
            view: 'email/talk/time_slot_accepted',
            data: ['timeSlot' => $timeSlot]
        );

        $this->sendEmailToAdmins(
            talk: $talk,
            subject: 'Zeitfenster für Vortrag akzeptiert',
            view: 'email/admin/time_slot_accepted',
            data: ['timeSlot' => $timeSlot]
        );

        return $this->response->setJSON(['success' => 'TIME_SLOT_ACCEPTED'])->setStatusCode(200);
    }

    public function rejectTimeSlot(int $talkId): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::REJECT_TIME_SLOT_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $talk = $this->tryGetTentativeTalk($talkId);
        if ($talk instanceof ResponseInterface) {
            return $talk;
        }

        $timeSlotModel = model(TimeSlotModel::class);
        $timeSlot = $timeSlotModel->get($talk['time_slot_id']);

        $talkModel = model(TalkModel::class);
        $talkModel->deleteTimeSlot($talkId);
        $talkModel->rejectTimeSlot($talkId); // Should be unnecessary, but better safe than sorry.

        $this->sendEmailToSpeaker(
            talk: $talk,
            subject: 'Zeitfenster für deinen Vortrag',
            view: 'email/talk/time_slot_rejected',
            data: [
                'timeSlot' => $timeSlot,
                'reason' => $validData['reason'] ?? null
            ]
        );

        $this->sendEmailToAdmins(
            talk: $talk,
            subject: 'Zeitfenster für Vortrag abgelehnt',
            view: 'email/admin/time_slot_rejected',
            data: [
                'timeSlot' => $timeSlot,
                'reason' => $validData['reason'] ?? null
            ]
        );

        return $this->response->setJSON(['success' => 'TIME_SLOT_REJECTED'])->setStatusCode(200);
    }

    private function sendEmailToSpeaker(
        array  $talk,
        string $subject,
        string $view,
        ?array $data = null
    ): void
    {
        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($talk['user_id']);
        $username = $account['username'];
        $email = $account['email'];

        $data = $data ?? [];
        $data['username'] = $username;
        $data['title'] = $talk['title'];

        EmailHelper::send(
            to: $email,
            subject: $subject,
            message: view($view, $data)
        );
    }

    private function sendEmailToAdmins(
        array  $talk,
        string $subject,
        string $view,
        ?array $data = null
    ): void
    {
        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($talk['user_id']);
        $username = $account['username'];
        $adminAccount = $accountModel->get($this->getLoggedInUserId());
        $adminUsername = $adminAccount['username'];

        $data = $data ?? [];
        $data['admin'] = $adminUsername;
        $data['username'] = $username;
        $data['title'] = $talk['title'];

        EmailHelper::sendToAdmins(
            subject: $subject,
            message: view($view, $data)
        );
    }

    private function tryGetTentativeTalk(int $talkId): array|ResponseInterface
    {
        $talkModel = model(TalkModel::class);
        $talk = $talkModel->get($talkId);
        if ($talk === null || $talk['user_id'] !== $this->getLoggedInUserId()) {
            return $this->response->setJSON(['error' => 'TALK_NOT_FOUND'])->setStatusCode(404);
        }
        if (!$talk['is_approved']) {
            return $this->response->setJSON(['error' => 'TALK_NOT_APPROVED'])->setStatusCode(400);
        }
        if ($talk['time_slot_id'] === null) {
            return $this->response->setJSON(['error' => 'NO_TIME_SLOT'])->setStatusCode(400);
        }
        if ($talk['time_slot_accepted']) {
            return $this->response->setJSON(['error' => 'TIME_SLOT_ALREADY_ACCEPTED'])->setStatusCode(400);
        }
        return $talk;
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
        $availableDurations = $talkDurationChoiceModel->getAll();
        foreach ($durations as $duration) {
            if (!in_array($duration, $availableDurations, strict: true)) {
                return false;
            }
        }
        return true;
    }

    /** Collects additional data for the passed talks (speaker, tags, possible durations,
     *  suggested time slot).
     * @param array $talks The talks to collect additional data for.
     * @return array The talks with additional data.
     */
    private function addAdditionalDataToTalks(array $talks): array
    {
        $tagModel = model(TagModel::class);
        $tagMapping = $tagModel->getTagMapping(array_column($talks, 'id'));

        $possibleTalkDurationModel = model(PossibleTalkDurationModel::class);

        $timeSlotModel = model(TimeSlotModel::class);

        $speakerModel = model(SpeakerModel::class);
        foreach ($talks as &$talk) {
            $speaker = $speakerModel->getLatestApprovedForEvent($talk['user_id'], $talk['event_id']);
            $talk['speaker'] = $speaker;
            unset($talk['user_id']);
            $talk['tags'] = $tagMapping[$talk['id']];
            $talk['possible_durations'] = array_column(
                $possibleTalkDurationModel->get($talk['id']),
                'duration'
            );
            $talk['suggested_time_slot'] =
                isset($talk['time_slot_id']) && $talk['time_slot_id'] != null
                    ? $timeSlotModel->get($talk['time_slot_id'])
                    : null;
            unset($talk['time_slot_id']);
        }

        return $talks;
    }

    private function isTimeSlotOccupied(int $timeSlotId): bool
    {
        $talkModel = model(TalkModel::class);
        $talk = $talkModel->findByTimeSlot($timeSlotId);
        return $talk !== null;
    }
}
