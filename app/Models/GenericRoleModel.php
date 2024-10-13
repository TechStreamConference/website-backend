<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Superclass for SpeakerModel and TeamMemberModel.
 */
class GenericRoleModel extends Model
{
    // child classes will have to set the protected $table field to make this class work

    protected $allowedFields = ['name', 'user_id', 'event_id', 'short_bio', 'bio', 'photo', 'photo_mime_type', 'is_approved', 'visible_from'];
    protected $useTimestamps = true;

    public function get(int $id): array|null
    {
        $result = $this->select('id, name, short_bio, bio, photo, photo_mime_type, is_approved, visible_from')->where('id', $id)->first();
        $result['id'] = intval($result['id']);
        $result['is_approved'] = boolval($result['is_approved']);
        return $result;
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
            ->get()
            ->getResultArray();

        foreach ($query as &$row) {
            $row['id'] = intval($row['id']);
            $row['user_id'] = intval($row['user_id']);
        }

        return $query;
    }

    public function create(
        string $name,
        int    $userId,
        int    $eventId,
        string $shortBio,
        string $bio,
        string $photo,
        string $photoMimeType,
        bool   $isActive,
        string $visibleFrom,
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
            'is_approved' => $isActive,
            'visible_from' => $visibleFrom,
        ]);
    }
}
