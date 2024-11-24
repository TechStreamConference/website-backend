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
}
