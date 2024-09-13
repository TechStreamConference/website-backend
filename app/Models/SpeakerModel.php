<?php

namespace App\Models;

use CodeIgniter\Model;

class SpeakerModel extends Model
{
    protected $table = 'Speaker';
    protected $allowedFields = ['name', 'short_bio', 'bio', 'photo', 'photo_mime_type', 'is_active', 'visible_from'];
    protected $useTimestamps = true;

    public function get(int $id): array|null
    {
        return $this->select('name, short_bio, bio, photo, photo_mime_type, is_active, visible_from')->where('id', $id)->first();
    }

    public function getPublished(): array
    {
        return $this->select('id, name, short_bio, bio, photo, photo_mime_type')->where('is_active', true)->where('visible_from <=', date('Y-m-d H:i:s'))->findAll();
    }

    public function create(
        string $name,
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
            'short_bio' => $shortBio,
            'bio' => $bio,
            'photo' => $photo,
            'photo_mime_type' => $photoMimeType,
            'is_active' => $isActive,
            'visible_from' => $visibleFrom,
        ]);
    }
}
