<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\EventModel;
use App\Models\SocialMediaLinkModel;
use App\Models\SpeakerModel;
use App\Models\TeamMemberModel;

enum Role: string
{
    case SPEAKER = 'speaker';
    case TEAM_MEMBER = 'reviewer';
}

class Approval extends BaseController
{
    private function getPendingRoleEntries(Role $role)
    {
        // From all pending speaker entries, get the latest one of each specific user.
        $roleModel = match ($role) {
            Role::SPEAKER => model(SpeakerModel::class),
            Role::TEAM_MEMBER => model(TeamMemberModel::class),
        };
        $pendingEntries = $roleModel->getPending();

        // We use an associative array to emulate a set of all user IDs.
        $userIds = [];
        foreach ($pendingEntries as $entry) {
            $userIds[$entry['user_id']] = true;
        }

        // Get the latest pending entry of each user.
        $latestPendingEntries = [];
        foreach ($pendingEntries as $entry) {
            if (!isset($latestPendingEntries[$entry['user_id']])) {
                $latestPendingEntries[$entry['user_id']] = $entry;
                continue;
            }
            $latestPendingEntry = $latestPendingEntries[$entry['user_id']];
            if (strtotime($entry['updated_at']) > strtotime($latestPendingEntry['updated_at'])) {
                $latestPendingEntries[$entry['user_id']] = $entry;
            }
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

        // Check if there's an already approved entry for each user. If you, build up a list of
        // all fields that differ between the latest pending entry and the approved entry and
        // add it to the latest pending entry.
        $allEntries = $roleModel->getAll();
        $latestApprovedEntries = [];
        foreach ($allEntries as $entry) {
            // Find the latest approved entry for each user.
            if ($entry['is_approved']) {
                if (!isset($latestApprovedEntries[$entry['user_id']])) {
                    $latestApprovedEntries[$entry['user_id']] = $entry;
                    continue;
                }
                $latestApprovedEntry = $latestApprovedEntries[$entry['user_id']];
                if (strtotime($entry['updated_at']) > strtotime($latestApprovedEntry['updated_at'])) {
                    $latestApprovedEntries[$entry['user_id']] = $entry;
                }
            }
        }

        foreach ($latestPendingEntries as &$latestPendingEntry) {
            $latestApprovedEntry = $latestApprovedEntries[$latestPendingEntry['user_id']] ?? null;
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
        };

        $result = $roleModel->approve($id);
        if (!$result) {
            return $this
                ->response
                ->setJSON(["error" => "Id not found or entry was already approved."])
                ->setStatusCode(400);
        }
        return $this->response->setStatusCode(204);
    }

    private function requestChangesForRoleEntry(Role $role, int $id)
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data, ['message' => 'required|string'])) {
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
            return $this
                ->response
                ->setJSON(["error" => "Id not found or entry was already approved."])
                ->setStatusCode(400);
        }
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
            return $this
                ->response
                ->setJSON(["error" => "Id not found or entry was already approved."])
                ->setStatusCode(400);
        }
        return $this->response->setStatusCode(204);
    }

    public function requestChangesForSocialMediaLink(int $id)
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data, ['message' => 'required|string'])) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();
        $message = $validData['message'];

        $socialMediaLinkModel = model(SocialMediaLinkModel::class);

        $result = $socialMediaLinkModel->requestChanges($id, $message);
        if (!$result) {
            return $this
                ->response
                ->setJSON(["error" => "Id not found or entry was already approved."])
                ->setStatusCode(400);
        }
        return $this->response->setStatusCode(204);
    }
}
