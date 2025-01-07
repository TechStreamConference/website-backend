<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SpeakerModel;
use CodeIgniter\HTTP\ResponseInterface;

class Talk extends BaseController
{
    /** Checks if the current user can submit a talk. It's not enough to have the
     * speaker role, but the user must also have an approved speaker entry for the
     * given event.
     * @param int $eventId The ID of the event in question.
     * @return ResponseInterface The response to return to the client (200 if the user can
     *                           submit a talk, 403 otherwise).
     */
    public function canSubmit(int $eventId): ResponseInterface
    {
        if ($this->canLoggedInUserSubmitTalk($eventId)) {
            return $this->response->setJSON(['can_submit_talk' => true])->setStatusCode(200);
        }
        return $this->response->setJSON(['error' => 'NO_APPROVED_SPEAKER_ENTRY'])->setStatusCode(403);
    }

    private function canLoggedInUserSubmitTalk(int $eventId): bool
    {
        $speakerModel = model(SpeakerModel::class);
        return $speakerModel->hasApprovedEntry($this->getLoggedInUserId(), $eventId);
    }
}
