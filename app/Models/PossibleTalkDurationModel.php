<?php

namespace App\Models;

use CodeIgniter\Model;

class PossibleTalkDurationModel extends Model
{
    protected $table = 'PossibleTalkDuration';
    protected $allowedFields = [
        'talk_id',
        'duration',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $useTimestamps = true;
    protected array $casts = [
        'talk_id' => 'int',
        'duration' => 'int',
    ];

    /**
     * Stores the possible durations for a talk.
     * @param int $talkId The ID of the talk.
     * @param int[] $possibleDurations The possible durations for the talk.
     */
    public function store(int $talkId, array $possibleDurations): void
    {
        $this->insertBatch(
            array_map(
                fn($duration) => ['talk_id' => $talkId, 'duration' => $duration],
                $possibleDurations
            )
        );
    }

    public function deleteAllForTalk(int $talkId): void
    {
        $this->where('talk_id', $talkId)->delete();
    }

    public function get(int $talkId): array
    {
        return $this->where('talk_id', $talkId)->orderBy('duration')->findAll();
    }
}
