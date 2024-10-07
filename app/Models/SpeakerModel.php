<?php

namespace App\Models;

use CodeIgniter\Model;

class SpeakerModel extends Model
{
    protected $table = 'Speaker';
    protected $allowedFields = ['name', 'user_id', 'event_id', 'short_bio', 'bio', 'photo', 'photo_mime_type', 'is_approved', 'visible_from'];
    protected $useTimestamps = true;

    public function get(int $id): array|null
    {
        return $this->select('id, name, short_bio, bio, photo, photo_mime_type, is_approved, visible_from')->where('id', $id)->first();
    }

    public function getPublished(int $eventId): array
    {
        $subQuery = $this->db->table('Speaker')
            ->select('id')
            ->where('Speaker.user_id = outer_speaker.user_id')
            ->where('is_approved', true)
            ->where('visible_from <=', date('Y-m-d H:i:s'))
            ->orderBy('updated_at', 'DESC')
            ->limit(1)
            ->getCompiledSelect();

        $query = $this->db->table('Speaker AS outer_speaker')
            ->select('user_id, name, short_bio, bio, photo')
            ->where('event_id = ', $eventId)
            ->where("id = ($subQuery)", null, false)
            ->get()
            ->getResultArray();

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
