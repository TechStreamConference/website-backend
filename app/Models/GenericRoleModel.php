<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Superclass for SpeakerModel and TeamMemberModel.
 */
class GenericRoleModel extends Model
{
    // child classes will have to set the protected $table field to make this class work

    protected $allowedFields = [
        'name',
        'user_id',
        'event_id',
        'short_bio',
        'bio',
        'photo',
        'photo_mime_type',
        'is_approved',
        'visible_from',
        'requested_changes'
    ];
    protected $useTimestamps = true;
    protected array $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'is_approved' => 'bool',
        'event_id' => 'int',
    ];

    public function get(int $id): array|null
    {
        return $this
            ->select('id, name, short_bio, bio, photo, photo_mime_type, is_approved, visible_from, requested_changes')
            ->where('id', $id)
            ->first();
    }

    public function getAll(): array
    {
        return $this
            ->select('id, name, user_id, event_id, short_bio, bio, photo, photo_mime_type, is_approved, visible_from, requested_changes, created_at, updated_at')
            ->findAll();
    }

    public function getAllForUser(int $userId): array
    {
        return $this
            ->select('Event.id as event_id, Event.title')
            ->join('Event', 'Event.id = event_id')
            ->where('user_id', $userId)
            ->groupBy('Event.id')
            ->findAll();
    }

    public function getPending(): array
    {
        return $this
            ->select('id, name, user_id, event_id, short_bio, bio, photo, photo_mime_type, visible_from, requested_changes, created_at, updated_at')
            ->where('is_approved', false)
            ->findAll();
    }

    public function approve(int $id): bool
    {
        $entry = $this->get($id);
        if ($entry === null || $entry['is_approved']) {
            return false;
        }
        return $this->update($id, ['is_approved' => true, 'requested_changes' => null]);
    }

    public function requestChanges(int $id, string $message): bool
    {
        $entry = $this->get($id);
        if ($entry === null || $entry['is_approved']) {
            return false;
        }
        return $this->update($id, ['requested_changes' => $message]);
    }

    public function getPublished(int $eventId): array
    {
        $subQuery = $this->db->table($this->table)
            ->select('id')
            ->where("$this->table.user_id = outer_table.user_id")
            ->where('is_approved', true)
            ->where('visible_from <=', date('Y-m-d H:i:s'))
            ->orderBy('updated_at', 'DESC')
            ->limit(1)
            ->getCompiledSelect();

        $query = $this->db->table("$this->table AS outer_table")
            ->select('id, user_id, name, short_bio, bio, photo')
            ->where('event_id = ', $eventId)
            ->where("id = ($subQuery)", null, false)
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($query as &$row) {
            $row['id'] = intval($row['id']);
            $row['user_id'] = intval($row['user_id']);
        }

        return $query;
    }

    public function getApproved(int $eventId): array
    {
        $subQuery = $this->db->table($this->table)
            ->select('id')
            ->where("$this->table.user_id = outer_table.user_id")
            ->where('is_approved', true)
            ->orderBy('updated_at', 'DESC')
            ->limit(1)
            ->getCompiledSelect();

        $query = $this->db->table("$this->table AS outer_table")
            ->select('id, user_id, name, short_bio, bio, photo, visible_from')
            ->where('event_id = ', $eventId)
            ->where("id = ($subQuery)", null, false)
            ->get()
            ->getResultArray();

        foreach ($query as &$row) {
            $row['id'] = intval($row['id']);
            $row['user_id'] = intval($row['user_id']);
        }

        return $query;
    }

    public function getLatestForEvent(int $userId, int $eventId): array|null
    {
        // This returns the latest entry for the given user and the given event,
        // regardless of whether it is approved or not.
        return $this
            ->select('id, user_id, name, short_bio, bio, photo, photo_mime_type, is_approved, visible_from, requested_changes')
            ->where('event_id', $eventId)
            ->where('user_id', $userId)
            ->orderBy('updated_at', 'DESC')
            ->limit(1)
            ->first();
    }

    public function create(
        string $name,
        int    $userId,
        int    $eventId,
        string $shortBio,
        string $bio,
        string $photo,
        string $photoMimeType,
        bool   $isApproved,
        ?string $visibleFrom,
    ): int
    {
        return $this->insert([
            'name' => $name,
            'user_id' => $userId,
            'event_id' => $eventId,
            'short_bio' => $shortBio,
            'bio' => $bio,
            'photo' => $photo,
            'photo_mime_type' => $photoMimeType,
            'is_approved' => $isApproved,
            'visible_from' => $visibleFrom ?? null,
        ]);
    }
}
