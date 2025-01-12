<?php

namespace App\Models;

class SpeakerModel extends GenericRoleModel
{
    protected $table = 'Speaker';

    public function deleteAllForEvent(int $userId, int $eventId): void
    {
        $this->where('user_id', $userId)
            ->where('event_id', $eventId)
            ->delete();
    }
}
