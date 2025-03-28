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
            ->select('id, name, user_id, short_bio, bio, photo, photo_mime_type, is_approved, visible_from, requested_changes')
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
            ->select('Event.id as event_id, Event.title, name, user_id, event_id, short_bio, bio, photo, photo_mime_type, is_approved, visible_from, requested_changes')
            ->join('Event', 'Event.id = event_id')
            ->where('user_id', $userId)
            ->groupBy('Event.id')
            ->findAll();
    }

    public function getAllForUserAndEvent(int $userId, int $eventId): array
    {
        return $this
            ->select('id, name, user_id, event_id, short_bio, bio, photo, photo_mime_type, is_approved, visible_from, requested_changes, created_at, updated_at')
            ->where('user_id', $userId)
            ->where('event_id', $eventId)
            ->findAll();
    }

    public function hasEntry(int $userId, int $eventId): bool
    {
        return $this
                ->select('id')
                ->where('user_id', $userId)
                ->where('event_id', $eventId)
                ->countAllResults() > 0;
    }

    public function hasApprovedEntry(int $userId, int $eventId): bool
    {
        return $this
                ->select('id')
                ->where('user_id', $userId)
                ->where('event_id', $eventId)
                ->where('is_approved', true)
                ->countAllResults() > 0;
    }

    public function getLatestPerUserPerEvent(): array
    {
        $subQuery = $this->db->table($this->table)
            ->select('MAX(id) as id')
            ->where("$this->table.user_id = outer_table.user_id", null, false)
            ->where("$this->table.event_id = outer_table.event_id", null, false)
            ->getCompiledSelect();

        $query = $this->db->table("$this->table AS outer_table")
            ->select('id, user_id, event_id, name, short_bio, bio, photo, photo_mime_type, is_approved, visible_from, requested_changes')
            ->where("id IN ($subQuery)")
            ->get()
            ->getResultArray();

        foreach ($query as &$row) {
            $row['id'] = (int)$row['id'];
            $row['user_id'] = (int)$row['user_id'];
            $row['event_id'] = (int)$row['event_id'];
            $row['is_approved'] = (bool)$row['is_approved'];
        }

        return $query;
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
            $row['id'] = (int)$row['id'];
            $row['user_id'] = (int)$row['user_id'];
        }

        return $query;
    }

    public function getApproved(int $eventId): array
    {
        $subQuery = $this->db->table($this->table)
            ->select('id')
            ->where("$this->table.user_id = outer_table.user_id")
            ->where('is_approved', true)
            ->where('event_id', $eventId)
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
            $row['id'] = (int)$row['id'];
            $row['user_id'] = (int)$row['user_id'];
        }

        return $query;
    }

    /** Returns the latest entry for the given user and the given event,
     * regardless of whether it is approved or not.
     * @param int $userId The ID of the user.
     * @param int $eventId The ID of the event.
     * @return array|null The entry, or null if no entry was found.
     */
    public function getLatestForEvent(int $userId, int $eventId): array|null
    {
        return $this
            ->select('id, user_id, name, short_bio, bio, photo, photo_mime_type, is_approved, visible_from, requested_changes')
            ->where('event_id', $eventId)
            ->where('user_id', $userId)
            ->orderBy('updated_at', 'DESC')
            ->first();
    }

    /** Returns the latest approved entry for the given user and the given event.
     * @param int $userId The ID of the user.
     * @param int $eventId The ID of the event.
     * @return array|null The entry, or null if no entry was found.
     */
    public function getLatestApprovedForEvent(int $userId, int $eventId): array|null
    {
        return $this
            ->select('id, user_id, name, short_bio, bio, photo, photo_mime_type, is_approved, visible_from, requested_changes')
            ->where('event_id', $eventId)
            ->where('user_id', $userId)
            ->where('is_approved', true)
            ->orderBy('updated_at', 'DESC')
            ->first();
    }

    public function create(
        string  $name,
        int     $userId,
        int     $eventId,
        string  $shortBio,
        string  $bio,
        string  $photo,
        string  $photoMimeType,
        bool    $isApproved,
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
