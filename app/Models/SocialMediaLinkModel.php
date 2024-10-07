<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialMediaLinkModel extends Model
{
    protected $table = 'SocialMediaLink';
    protected $allowedFields = ['social_media_type_id', 'speaker_id', 'url'];
    protected $useTimestamps = true;

    public function get_by_user_ids(array $userIds): array
    {
        $queryResult = $this
            ->select('user_id, name, url')
            ->join('SocialMediaType', 'SocialMediaType.id = SocialMediaLink.social_media_type_id')
            ->whereIn('user_id', $userIds)
            ->findAll();
        $result = [];
        foreach ($queryResult as $row) {
            $result[$row['user_id']][] = [
                'name' => $row['name'],
                'url' => $row['url'],
            ];
        }
        return $result;
    }
}
