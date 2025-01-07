<?php

namespace App\Helpers;

/**
 * Represents the data of a row in the TimeSlot table.
 */
class TimeSlotData
{
    public ?int $id;
    public int $eventId;
    public string $startTime;
    public int $duration;

    private function __construct(
        ?int   $id,
        int    $eventId,
        string $startTime,
        int    $duration
    )
    {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->startTime = $startTime;
        $this->duration = $duration;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'event_id' => $this->eventId,
            'start_time' => $this->startTime,
            'duration' => $this->duration,
        ];
    }

    public function toArrayWithoutId(): array
    {
        return [
            'event_id' => $this->eventId,
            'start_time' => $this->startTime,
            'duration' => $this->duration,
        ];
    }

    public static function fromArray(array $array): TimeSlotData
    {
        return new TimeSlotData(
            $array['id'] ?? null,
            $array['event_id'],
            $array['start_time'],
            $array['duration']
        );
    }

    public static function make(
        int    $eventId,
        string $startTime,
        int    $duration
    ): TimeSlotData
    {
        return new TimeSlotData(
            null,
            $eventId,
            $startTime,
            $duration
        );
    }
}
