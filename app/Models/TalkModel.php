<?php

namespace App\Models;

use CodeIgniter\Model;

class TalkModel extends Model
{
    protected $table = 'Talk';
    protected $allowedFields = [
        'event_id',
        'user_id',
        'starts_at',
        'title',
        'description',
        'is_special',
        'requested_changes',
        'is_approved',
        'time_slot_id',
        'time_slot_accepted',
    ];
    protected $useTimestamps = true;
    protected array $casts = [
        'id' => 'int',
        'event_id' => 'int',
        'user_id' => 'int',
        'duration' => 'int',
        'is_special' => 'bool',
        'is_approved' => 'bool',
        'time_slot_id' => 'int',
        'time_slot_accepted' => 'bool',
    ];

    public function getApprovedByEventId(int $eventId): array
    {
        return $this
            ->select('id, user_id, starts_at, title, description, is_special, requested_changes, is_approved, time_slot_id, time_slot_accepted')
            ->where('event_id', $eventId)
            ->where('requested_changes IS NULL')
            ->where('is_approved', true)
            ->where('time_slot_id IS NOT NULL')
            ->where('time_slot_accepted', true)
            ->orderBy('starts_at', 'ASC')
            ->findAll();
    }
}
