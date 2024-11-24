<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialMediaLinkModel extends Model
{
    protected $table = 'SocialMediaLink';
    protected $allowedFields = [
        'user_id',
        'social_media_type_id',
        'speaker_id',
        'url',
        'approved',
        'requested_changes'
    ];
    protected $useTimestamps = true;
    protected array $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'social_media_type_id' => 'int',
        'speaker_id' => 'int',
        'approved' => 'bool',
    ];

    public function getApprovedByUserIds(array $userIds): array
    {
        if (count($userIds) === 0) {
            return [];
        }
        $queryResult = $this
            ->select('user_id, name, url')
            ->join('SocialMediaType', 'SocialMediaType.id = SocialMediaLink.social_media_type_id')
            ->where('approved', true)
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

    private function get(int $id): array|null
    {
        return $this
            ->select('user_id, name, url, approved, requested_changes')
            ->where('SocialMediaLink.id', $id)
            ->join('SocialMediaType', 'SocialMediaType.id = SocialMediaLink.social_media_type_id')
            ->first();
    }

    public function getPending(): array
    {
        return $this
            ->select('SocialMediaLink.id, user_id, name, url, requested_changes')
            ->where('approved', false)
            ->join('SocialMediaType', 'SocialMediaType.id = SocialMediaLink.social_media_type_id')
            ->findAll();
    }

    public function approve(int $id): bool
    {
        $entry = $this->get($id);
        if ($entry === null || $entry['approved']) {
            return false;
        }
        return $this->update($id, ['approved' => true, 'requested_changes' => null]);
    }

    public function requestChanges(int $id, string $message): bool
    {
        $entry = $this->get($id);
        if ($entry === null || $entry['approved']) {
            return false;
        }
        return $this->update($id, ['requested_changes' => $message]);
    }
}
