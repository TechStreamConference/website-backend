<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialMediaLinkModel extends Model
{
    protected $table = 'SocialMediaLink';
    protected $allowedFields = ['social_media_type_id', 'speaker_id', 'url'];
    protected $useTimestamps = true;

    public function get_by_speaker_id(int $speakerId): array
    {
        return $this->select('social_media_type_id, url')->where('speaker_id', $speakerId)->findAll();
    }
}
