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
    public bool $isSpecial;

    private function __construct(
        ?int   $id,
        int    $eventId,
        string $startTime,
        int    $duration,
        bool   $isSpecial
    )
    {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->startTime = $startTime;
        $this->duration = $duration;
        $this->isSpecial = $isSpecial;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'event_id' => $this->eventId,
            'start_time' => $this->startTime,
            'duration' => $this->duration,
            'is_special' => $this->isSpecial,
        ];
    }

    public function toArrayWithoutId(): array
    {
        return [
            'event_id' => $this->eventId,
            'start_time' => $this->startTime,
            'duration' => $this->duration,
            'is_special' => $this->isSpecial,
        ];
    }

    public static function fromArray(array $array): TimeSlotData
    {
        return new TimeSlotData(
            $array['id'] ?? null,
            $array['event_id'],
            $array['start_time'],
            $array['duration'],
            $array['is_special'],
        );
    }

    public static function make(
        int    $eventId,
        string $startTime,
        int    $duration,
        bool   $isSpecial
    ): TimeSlotData
    {
        return new TimeSlotData(
            null,
            $eventId,
            $startTime,
            $duration,
            $isSpecial,
        );
    }
}
