<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoRoomModel extends Model
{
    protected $table = 'VideoRoom';
    protected $allowedFields = [
        'event_id',
        'base_url',
        'room_id',
        'password',
        'visible_from',
    ];
    protected $useTimestamps = true;
    protected array $casts = [
        'event_id' => 'int',
    ];

    public function createOrUpdate(
        int    $eventId,
        string $baseUrl,
        string $roomId,
        string $password
    ): int
    {
        $data = [
            'event_id' => $eventId,
            'base_url' => $baseUrl,
            'room_id' => $roomId,
            'password' => $password,
        ];
        $this->where('event_id', $eventId)->delete();
        return $this->insert($data);
    }

    public function get(int $eventId): ?array
    {
        return $this->where('event_id', $eventId)->first();
    }

    public function setVisibleFrom(int $eventId, string $visibleFrom): bool
    {
        return $this
            ->where('event_id', $eventId)
            ->set(['visible_from' => $visibleFrom])
            ->update();
    }
}
