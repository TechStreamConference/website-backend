<?php

namespace App\Controllers;

use App\Helpers\EmailHelper;
use App\Helpers\Role;
use App\Models\AccountModel;
use App\Models\EventModel;
use App\Models\SocialMediaLinkModel;
use App\Models\SpeakerModel;
use App\Models\TeamMemberModel;
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

    private function approveRoleEntry(Role $role, int $id)
    {
        $roleModel = match ($role) {
            Role::SPEAKER => model(SpeakerModel::class),
            Role::TEAM_MEMBER => model(TeamMemberModel::class),
            default => null,
        };
        if ($roleModel === null) {
            return $this->response->setStatusCode(500);
        }

        $result = $roleModel->approve($id);
        if (!$result) {
            // Id not found or entry was already approved.
            return $this
                ->response
                ->setJSON(['error' => 'ID_NOT_FOUND_OR_ALREADY_APPROVED'])
                ->setStatusCode(400);
        }

        $entry = $roleModel->get($id);
        $userId = $entry['user_id'];

        $this->sendConfirmationEmails(
            $userId,
            'Datensatz freigeschaltet',
            'contributor_entry_approved'
        );

        return $this->response->setStatusCode(204);
    }

    private function requestChangesForRoleEntry(Role $role, int $id)
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], ['message' => 'required|string'])) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
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
                ->setStatusCode(400);
        }

        $entry = $roleModel->get($id);
        $userId = $entry['user_id'];

        $this->sendRequestedChangesEmails(
            $userId,
            'Änderungswünsche für Datensatz',
            'contributor_entry_requested_changes',
            $message
        );

        return $this->response->setStatusCode(204);
    }

    public function getPendingSpeakers()
    {
        return $this->getPendingRoleEntries(Role::SPEAKER);
    }

    public function getPendingTeamMembers()
    {
        return $this->getPendingRoleEntries(Role::TEAM_MEMBER);
    }

    public function approveSpeaker(int $id)
    {
        return $this->approveRoleEntry(Role::SPEAKER, $id);
    }

    public function approveTeamMember(int $id)
    {
        return $this->approveRoleEntry(Role::TEAM_MEMBER, $id);
    }

    public function requestChangesForSpeaker(int $id)
    {
        return $this->requestChangesForRoleEntry(Role::SPEAKER, $id);
    }

    public function requestChangesForTeamMember(int $id)
    {
        return $this->requestChangesForRoleEntry(Role::TEAM_MEMBER, $id);
    }

    public function getPendingSocialMediaLinks()
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

    public function approveSocialMediaLink(int $id)
    {
        $socialMediaLinkModel = model(SocialMediaLinkModel::class);
        $result = $socialMediaLinkModel->approve($id);
        if (!$result) {
            // Id not found or entry was already approved.
            return $this
                ->response
                ->setJSON(['error' => 'ID_NOT_FOUND_OR_ALREADY_APPROVED'])
                ->setStatusCode(400);
        }

        $entry = $socialMediaLinkModel->get($id);
        $userId = $entry['user_id'];

        $this->sendConfirmationEmails(
            $userId,
            'Social-Media-Link freigeschaltet',
            'social_media_link_approved'
        );

        return $this->response->setStatusCode(204);
    }

    public function requestChangesForSocialMediaLink(int $id)
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], ['message' => 'required|string'])) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
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
                ->setStatusCode(400);
        }

        $entry = $socialMediaLinkModel->get($id);
        $userId = $entry['user_id'];

        $this->sendRequestedChangesEmails(
            $userId,
            'Änderungswünsche für Social-Media-Link',
            'social_media_link_requested_changes',
            $message
        );

        return $this->response->setStatusCode(204);
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
    ): void
    {
        $this->sendMailsToUserAndAdmins(
            $userId,
            $subject,
            $viewName,
        );
    }

    private function sendRequestedChangesEmails(
        int    $userId,
        string $subject,
        string $viewName,
        string $requestedChanges,
    ): void
    {
        $this->sendMailsToUserAndAdmins(
            $userId,
            $subject,
            $viewName,
            ['requestedChanges' => $requestedChanges],
        );
    }
}
