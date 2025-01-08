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
        'is_approved' => 'bool',
        'time_slot_id' => '?int',
        'time_slot_accepted' => 'bool',
    ];

    public function getApprovedByEventId(int $eventId): array
    {
        return $this
            ->select('id, event_id, user_id, title, description, time_slot_id')
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
            'requested_changes' => $requestedChanges,
            'is_approved' => $isApproved,
            'time_slot_id' => $timeSlotId,
            'time_slot_accepted' => $timeSlotAccepted,
        ]);
    }

    public function change(
        int     $talkId,
        int     $eventId,
        int     $userId,
        string  $title,
        string  $description,
        ?string $notes,
        ?string $requestedChanges,
        bool    $isApproved,
        ?int    $timeSlotId,
        bool    $timeSlotAccepted,
    ): bool
    {
        return $this->update(
            $talkId,
            [
                'event_id' => $eventId,
                'user_id' => $userId,
                'title' => $title,
                'description' => $description,
                'notes' => $notes,
                'requested_changes' => $requestedChanges,
                'is_approved' => $isApproved,
                'time_slot_id' => $timeSlotId,
                'time_slot_accepted' => $timeSlotAccepted,
            ],
        );
    }

    public function getAllPending(): array
    {
        return $this
            ->select('id, event_id, user_id, title, description, notes, requested_changes, created_at')
            ->where('is_approved', false)
            ->orderBy('created_at')
            ->findAll();
    }

    public function getAllTentative(): array
    {
        return $this
            ->select('id, event_id, user_id, title, description, notes, requested_changes, created_at')
            ->where('is_approved', true)
            ->where('time_slot_accepted', false)
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

    public function deleteRequestedChanges(int $talkId): void
    {
        $this->update($talkId, ['requested_changes' => null]);
    }

    public function approve(int $talkId): void
    {
        $this->update($talkId, ['is_approved' => true]);
    }
}
