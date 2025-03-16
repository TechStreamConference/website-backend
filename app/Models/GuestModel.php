<?php

namespace App\Models;

use CodeIgniter\Model;

class GuestModel extends Model
{
    protected $table = 'Guest';
    protected $allowedFields = [
        'talk_id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $useTimestamps = true;
    protected array $casts = [
        'talk_id' => 'int',
        'user_id' => 'int',
    ];

    public function getGuestsOfTalk(int $talkId): array
    {
        return $this->where('talk_id', $talkId)->findAll();
    }

    /**
     * @param int[] $talkIds
     * @return array
     */
    public function getGuestsOfTalks(array $talkIds): array
    {
        if (empty($talkIds)) {
            return [];
        }
        return $this
            ->whereIn('talk_id', $talkIds)
            ->orderBy('talk_id')
            ->findAll();
    }

    public function deleteAllForTalk(int $talkId): void
    {
        $this->where('talk_id', $talkId)->delete();
    }

    public function setGuests(int $talkId, array $guestIds): void
    {
        $this->deleteAllForTalk($talkId);
        $this->insertBatch(
            array_map(
                fn($guestId) => ['talk_id' => $talkId, 'user_id' => $guestId],
                $guestIds
            )
        );
    }
}
