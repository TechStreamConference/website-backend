<?php

namespace App\Controllers;

use App\Helpers\EmailHelper;
use App\Helpers\PathHelper;
use App\Helpers\Role;
use App\Models\AccountModel;
use App\Models\EventModel;
use App\Models\SocialMediaLinkModel;
use App\Models\SpeakerModel;
use App\Models\TalkModel;
use App\Models\TeamMemberModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Approval extends BaseController
{
    private function getPendingRoleEntries(Role $role): ResponseInterface
    {
        // From all pending speaker entries, get the latest one of each specific user.
        $roleModel = match ($role) {
            Role::SPEAKER => model(SpeakerModel::class),
            Role::TEAM_MEMBER => model(TeamMemberModel::class),
            Role::ADMIN => throw new \Exception("Invalid role."),
        };
        $pendingEntries = $roleModel->getLatestPerUserPerEvent();

        // Remove entries that are already approved.
        $latestPendingEntries = array_filter($pendingEntries, fn($entry) => !$entry['is_approved']);

        foreach ($latestPendingEntries as &$entry) {
            unset($entry['updated_at']);
            unset($entry['created_at']);
            unset($entry['is_approved']);
        }

        $accountModel = model(AccountModel::class);
        foreach ($latestPendingEntries as &$latestPendingEntry) {
            $account = $accountModel->get($latestPendingEntry['user_id']);

            // $account may be null, but that's okay.
            $latestPendingEntry['account'] = $account;
        }

        $eventModel = model(EventModel::class);
        $events = $eventModel->getAll();
        $eventsById = [];
        foreach ($events as $event) {
            $eventsById[$event['id']] = $event;
        }

        foreach ($latestPendingEntries as &$latestPendingEntry) {
            $latestPendingEntry['event'] = $eventsById[$latestPendingEntry['event_id']];
        }

        $allEntries = $roleModel->getAll();

        foreach ($latestPendingEntries as &$latestPendingEntry) {
            // Find the latest approved entry (based on updated_at) for this user and event.
            $latestApprovedEntry = null;
            unset($entry);
            foreach ($allEntries as $entry) {
                if (
                    $entry['user_id'] === $latestPendingEntry['user_id']
                    && $entry['event_id'] === $latestPendingEntry['event_id']
                    && $entry['is_approved']
                    && ($latestApprovedEntry === null || $entry['updated_at'] > $latestApprovedEntry['updated_at'])
                ) {
                    $latestApprovedEntry = $entry;
                }
            }

            if ($latestApprovedEntry === null) {
                $latestPendingEntry['diff'] = [];
                continue;
            }

            $diff = [];
            foreach ($latestPendingEntry as $key => $value) {
                if (
                    $key === 'account'
                    || $key === 'event'
                    || $key === 'id'
                    || $key === 'requested_changes'
                ) {
                    continue;
                }
                if ($latestApprovedEntry[$key] !== $value) {
                    $diff[] = $key;
                }
            }
            $latestPendingEntry['diff'] = $diff;
        }

        // Flatten the associative array to a simple array.
        $latestPendingEntries = array_values($latestPendingEntries);

        return $this->response->setJSON($latestPendingEntries);
    }

    private function approveRoleEntry(Role $role, int $id): ResponseInterface
    {
        $roleModel = match ($role) {
            Role::SPEAKER => model(SpeakerModel::class),
            Role::TEAM_MEMBER => model(TeamMemberModel::class),
            default => null,
        };
        if ($roleModel === null) {
            return $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        $result = $roleModel->approve($id);
        if (!$result) {
            // Id not found or entry was already approved.
            return $this
                ->response
                ->setJSON(['error' => 'ID_NOT_FOUND_OR_ALREADY_APPROVED'])
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $entry = $roleModel->get($id);
        $userId = $entry['user_id'];

        $this->sendConfirmationEmails(
            $userId,
            'Datensatz freigeschaltet',
            'contributor_entry_approved'
        );

        return $this
            ->response
            ->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
    }

    private function requestChangesForRoleEntry(Role $role, int $id): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], ['message' => 'required|string'])) {
            return $this
                ->response
                ->setJSON($this->validator->getErrors())
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        $validData = $this->validator->getValidated();
        $message = $validData['message'];

        $roleModel = match ($role) {
            Role::SPEAKER => model(SpeakerModel::class),
            Role::TEAM_MEMBER => model(TeamMemberModel::class),
        };

        $result = $roleModel->requestChanges($id, $message);
        if (!$result) {
            // Id not found or entry was already approved.
            return $this
                ->response
                ->setJSON(['error' => 'ID_NOT_FOUND_OR_ALREADY_APPROVED'])
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $entry = $roleModel->get($id);
        $userId = $entry['user_id'];

        $this->sendRequestedChangesEmails(
            $userId,
            'Änderungswünsche für Datensatz',
            'contributor_entry_requested_changes',
            $message
        );

        return $this
            ->response
            ->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
    }

    public function getPendingSpeakers(): ResponseInterface
    {
        return $this->getPendingRoleEntries(Role::SPEAKER);
    }

    public function canReject(int $userId, int $eventId): ResponseInterface
    {
        $canBeRejected = $this->checkIfSpeakerCanBeRejected($userId, $eventId);
        if ($canBeRejected instanceof ResponseInterface) {
            return $canBeRejected;
        }
        return $this->response->setJSON(['can_reject' => $canBeRejected]);
    }

    public function reject(int $userId, int $eventId): ResponseInterface
    {
        $canBeRejected = $this->checkIfSpeakerCanBeRejected($userId, $eventId);
        if ($canBeRejected instanceof ResponseInterface) {
            return $canBeRejected;
        }
        if (!$canBeRejected) {
            return $this
                ->response
                ->setJSON(['error' => 'SPEAKER_CANNOT_BE_REJECTED'])
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $speakerModel = model(SpeakerModel::class);
        $speakerEntries = $speakerModel->getAllForUserAndEvent($userId, $eventId);
        $imageFilenames = array_column($speakerEntries, 'photo');

        $error = false;
        foreach ($imageFilenames as $imageFilename) {
            if (!$this->deleteImage($imageFilename)) {
                $error = true;
            }
        }

        $speakerModel->deleteAllForEvent($userId, $eventId);
        if ($error) {
            return $this
                ->response
                ->setJSON(['error' => 'IMAGE_DELETION_FAILED'])
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->response->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
    }

    public function getPendingTeamMembers(): ResponseInterface
    {
        return $this->getPendingRoleEntries(Role::TEAM_MEMBER);
    }

    public function approveSpeaker(int $id): ResponseInterface
    {
        return $this->approveRoleEntry(Role::SPEAKER, $id);
    }

    public function approveTeamMember(int $id): ResponseInterface
    {
        return $this->approveRoleEntry(Role::TEAM_MEMBER, $id);
    }

    public function requestChangesForSpeaker(int $id): ResponseInterface
    {
        return $this->requestChangesForRoleEntry(Role::SPEAKER, $id);
    }

    public function requestChangesForTeamMember(int $id): ResponseInterface
    {
        return $this->requestChangesForRoleEntry(Role::TEAM_MEMBER, $id);
    }

    public function getPendingSocialMediaLinks(): ResponseInterface
    {
        $socialMediaLinkModel = model(SocialMediaLinkModel::class);
        $pendingLinks = $socialMediaLinkModel->getPending();

        $accountModel = model(AccountModel::class);
        foreach ($pendingLinks as &$pendingLink) {
            $account = $accountModel->get($pendingLink['user_id']);

            // $account may be null, but that's okay.
            $pendingLink['account'] = $account;
        }
        return $this->response->setJSON($pendingLinks);
    }

    public function approveSocialMediaLink(int $id): ResponseInterface
    {
        $socialMediaLinkModel = model(SocialMediaLinkModel::class);
        $result = $socialMediaLinkModel->approve($id);
        if (!$result) {
            // Id not found or entry was already approved.
            return $this
                ->response
                ->setJSON(['error' => 'ID_NOT_FOUND_OR_ALREADY_APPROVED'])
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $entry = $socialMediaLinkModel->get($id);
        $userId = $entry['user_id'];
        $url = $entry['url'];

        $this->sendConfirmationEmails(
            $userId,
            'Social-Media-Link freigeschaltet',
            'social_media_link_approved',
            ["url" => $url],
        );

        return $this
            ->response
            ->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
    }

    public function requestChangesForSocialMediaLink(int $id): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], ['message' => 'required|string'])) {
            return $this
                ->response
                ->setJSON($this->validator->getErrors())
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        $validData = $this->validator->getValidated();
        $message = $validData['message'];

        $socialMediaLinkModel = model(SocialMediaLinkModel::class);

        $result = $socialMediaLinkModel->requestChanges($id, $message);
        if (!$result) {
            // Id not found or entry was already approved.
            return $this
                ->response
                ->setJSON(['error' => 'ID_NOT_FOUND_OR_ALREADY_APPROVED'])
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $entry = $socialMediaLinkModel->get($id);
        $userId = $entry['user_id'];
        $url = $entry['url'];

        $this->sendRequestedChangesEmails(
            $userId,
            'Änderungswünsche für Social-Media-Link',
            'social_media_link_requested_changes',
            $message,
            ["url" => $url],
        );

        return $this
            ->response
            ->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
    }

    private function checkIfSpeakerCanBeRejected(int $userId, int $eventId): bool|ResponseInterface
    {
        $userModel = model(UserModel::class);
        $user = $userModel->getUser($userId);
        if ($user === null) {
            return $this
                ->response
                ->setJSON(['error' => 'USER_NOT_FOUND'])
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $eventModel = model(EventModel::class);
        $event = $eventModel->getPublished($eventId);
        if ($event === null) {
            return $this
                ->response
                ->setJSON(['error' => 'EVENT_NOT_FOUND'])
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $speakerModel = model(SpeakerModel::class);
        $canReject = $speakerModel->hasEntry($userId, $eventId) && !$speakerModel->hasApprovedEntry($userId, $eventId);

        if (!$canReject) {
            return false;
        }

        $talkModel = model(TalkModel::class);
        if ($talkModel->speakerHasTalks($userId, $eventId)) {
            return $this
                ->response
                ->setJSON(['error' => 'SPEAKER_HAS_TALKS'])
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
        return true;
    }

    private function deleteImage(string $filename): bool
    {
        $path = PathHelper::getImagePath($filename);
        if ($path == null) {
            return false;
        }
        return unlink($path);
    }

    private function sendMailsToUserAndAdmins(
        int    $userId,
        string $subject,
        string $viewName,
        array  $additionalData = [],
    ): void
    {
        $accountModel = model(AccountModel::class);
        $userAccount = $accountModel->get($userId);
        $username = $userAccount['username'];
        $userEmail = $userAccount['email'];

        $adminAccount = $accountModel->get($this->getLoggedInUserId());
        $adminUsername = $adminAccount['username'];

        $data = array_merge(
            [
                'admin' => $adminUsername,
                'username' => $username,
            ],
            $additionalData
        );

        EmailHelper::send(
            to: $userEmail,
            subject: $subject,
            message: view(
                "email/contributor/$viewName",
                $data,
            )
        );

        EmailHelper::sendToAdmins(
            subject: $subject,
            message: view(
                "email/admin/$viewName",
                $data,
            )
        );
    }

    private function sendConfirmationEmails(
        int    $userId,
        string $subject,
        string $viewName,
        array  $additionalData = [],
    ): void
    {
        $this->sendMailsToUserAndAdmins(
            $userId,
            $subject,
            $viewName,
            $additionalData,
        );
    }

    private function sendRequestedChangesEmails(
        int    $userId,
        string $subject,
        string $viewName,
        string $requestedChanges,
        array  $additionalData = [],
    ): void
    {
        $this->sendMailsToUserAndAdmins(
            $userId,
            $subject,
            $viewName,
            array_merge(
                ['requestedChanges' => $requestedChanges],
                $additionalData
            ),
        );
    }
}
