<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialMediaLinkModel extends Model
{
    protected $table = 'SocialMediaLink';
    protected $allowedFields = ['social_media_type_id', 'speaker_id', 'url'];
    protected $useTimestamps = true;

    public function get_by_speaker_ids(array $speakerIds): array
    {
        $queryResult = $this->select('speaker_id, name, url')->join('SocialMediaType', 'SocialMediaType.id = SocialMediaLink.social_media_type_id')->whereIn('speaker_id', $speakerIds)->findAll();
        $result = [];
        foreach ($queryResult as $row) {
            $result[$row['speaker_id']][] = [
                'name' => $row['name'],
                'url' => $row['url'],
            ];
        }
        return $result;
    }
}
