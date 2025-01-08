<?php

namespace App\Models;

use CodeIgniter\Model;

class TalkModel extends Model
{
    protected $table = 'Talk';
    protected $allowedFields = [
        'event_id',
        'user_id',
        'title',
        'description',
        'notes',
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
        'is_special' => 'bool',
        'is_approved' => 'bool',
        'time_slot_id' => '?int',
        'time_slot_accepted' => 'bool',
    ];

    public function getApprovedByEventId(int $eventId): array
    {
        return $this
            ->select('id, event_id, user_id, title, description, is_special, time_slot_id')
            ->where('event_id', $eventId)
            ->where('requested_changes IS NULL')
            ->where('is_approved', true)
            ->where('time_slot_id IS NOT NULL')
            ->where('time_slot_accepted', true)
            ->findAll();
    }

    public function doesTitleExist(string $title, int $eventId): bool
    {
        return $this
                ->select('id')
                ->where('title', $title)
                ->where('event_id', $eventId)
                ->countAllResults() > 0;
    }

    public function create(
        int     $eventId,
        int     $userId,
        string  $title,
        string  $description,
        ?string $notes,
        bool    $isSpecial,
        ?string $requestedChanges,
        bool    $isApproved,
        ?int    $timeSlotId,
        bool    $timeSlotAccepted,
    ): int|bool
    {
        return $this->insert([
            'event_id' => $eventId,
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'notes' => $notes,
            'is_special' => $isSpecial,
            'requested_changes' => $requestedChanges,
            'is_approved' => $isApproved,
            'time_slot_id' => $timeSlotId,
            'time_slot_accepted' => $timeSlotAccepted,
        ]);
    }

    public function getAllPending(): array
    {
        return $this
            ->select('id, event_id, user_id, title, description, notes, requested_changes, created_at')
            ->where('is_approved', false)
            ->orderBy('created_at')
            ->findAll();
    }

    public function get(int $talkdId): ?array
    {
        return $this
            ->select('id, event_id, user_id, title, description, notes, requested_changes, is_approved, time_slot_id, time_slot_accepted')
            ->where('id', $talkdId)
            ->first();
    }

    public function requestChanges(int $talkId, string $requestedChanges): void
    {
        $this->update($talkId, ['requested_changes' => $requestedChanges]);
    }
}
