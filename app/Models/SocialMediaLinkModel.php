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

    public function getLatestApprovedByUserIds(array $userIds): array
    {
        if (count($userIds) === 0) {
            return [];
        }
        $subQuery = $this->db->table($this->table)
            ->select('user_id, social_media_type_id, MAX(updated_at) as latest_update')
            ->where('approved', true)
            ->whereIn('user_id', $userIds)
            ->groupBy('user_id, social_media_type_id')
            ->getCompiledSelect();

        $queryResult = $this
            ->select('user_id, name, url')
            ->where("($this->table.user_id, $this->table.social_media_type_id, $this->table.updated_at) IN ($subQuery)", null, false)
            ->whereIn('user_id', $userIds)
            ->join('SocialMediaType', 'SocialMediaType.id = SocialMediaLink.social_media_type_id')
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

    public function get(int $id): array|null
    {
        return $this
            ->select('SocialMediaLink.id, social_media_type_id, user_id, name, url, approved, requested_changes')
            ->where('SocialMediaLink.id', $id)
            ->join('SocialMediaType', 'SocialMediaType.id = SocialMediaLink.social_media_type_id')
            ->first();
    }

    public function getPending(): array
    {
        $subQuery = $this->db->table($this->table)
            ->select('social_media_type_id, MAX(updated_at) as latest_update')
            ->where('approved', false)
            ->groupBy('social_media_type_id')
            ->getCompiledSelect();
        return $this
            ->select('SocialMediaLink.id, user_id, name, url, requested_changes')
            ->where("($this->table.social_media_type_id, $this->table.updated_at) IN ($subQuery)", null, false)
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

    public function getLatestForUser(int $userId): array
    {
        // For each type of social media link, get the most recent one, regardless
        // of whether it is approved or not.
        $subQuery = $this->db->table($this->table)
            ->select('social_media_type_id, MAX(updated_at) as latest_update')
            ->where('user_id', $userId)
            ->groupBy('social_media_type_id')
            ->getCompiledSelect();
        return $this
            ->select('SocialMediaLink.id, SocialMediaLink.user_id, SocialMediaLink.social_media_type_id, name, url, approved, requested_changes')
            ->where("($this->table.social_media_type_id, $this->table.updated_at) IN ($subQuery)", null, false)
            ->where('SocialMediaLink.user_id', $userId)
            ->join('SocialMediaType', 'SocialMediaType.id = SocialMediaLink.social_media_type_id')
            ->findAll();
    }

    public function getByLinkTypeAndUserId(int $social_media_type_id, int $user_id): array|null
    {
        return $this
            ->select('id, user_id, social_media_type_id, url, approved, requested_changes')
            ->where('social_media_type_id', $social_media_type_id)
            ->where('user_id', $user_id)
            ->first();
    }

    public function create(
        int    $social_media_type_id,
        int    $user_id,
        string $url,
        bool   $approved
    ): int
    {
        return $this->insert([
            'social_media_type_id' => $social_media_type_id,
            'user_id' => $user_id,
            'url' => $url,
            'approved' => $approved,
        ]);
    }

    public function updateLink(
        int    $id,
        int    $social_media_type_id,
        int    $user_id,
        string $url,
        bool   $approved,
        ?string $requested_changes
    ): int
    {
        return $this->update($id, [
            'social_media_type_id' => $social_media_type_id,
            'user_id' => $user_id,
            'url' => $url,
            'approved' => $approved,
            'requested_changes' => $requested_changes ?? null,
        ]);
    }
}
