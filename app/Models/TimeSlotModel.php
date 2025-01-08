<?php

namespace App\Models;

use App\Helpers\TimeSlotData;
use CodeIgniter\Model;

class TimeSlotModel extends Model
{
    protected $table = 'TimeSlot';
    protected $allowedFields = [
        'event_id',
        'start_time',
        'duration',
        'is_special',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $useTimestamps = true;
    protected array $casts = [
        'id' => 'int',
        'event_id' => 'int',
        'duration' => 'int',
        'is_special' => 'bool',
    ];

    /**
     * Stores time slots for an event. The $id property of each TimeSlot object
     * is ignored.
     *
     * @param TimeSlotData[] $timeSlots
     * @return bool True if the operation was successful, false otherwise.
     */
    public function store(array $timeSlots): bool
    {
        $data = array_map(
            fn($timeSlot) => $timeSlot->toArrayWithoutId(), // Ignore IDs.
            $timeSlots,
        );

        // insertBatch() returns the number of rows inserted (int) or false on failure
        return $this->insertBatch($data) !== false;
    }

    /**
     * Deletes all time slots for an event (if any).
     * @param int $eventId
     */
    public function deleteAllOfEvent(int $eventId): void
    {
        $this->where('event_id', $eventId)->delete();
    }

    /**
     * Gets all time slots for an event.
     * @param int $eventId
     * @return TimeSlotData[] An array of TimeSlot objects.
     */
    public function getByEventId(int $eventId): array
    {
        return array_map(
            TimeSlotData::fromArray(...),
            $this->where('event_id', $eventId)->orderBy('start_time')->findAll(),
        );
    }

    /**
     * Gets time slots by their IDs.
     * @param int[] $ids The IDs of the time slots.
     * @return TimeSlotData[] An array of TimeSlot objects.
     */
    public function getByIds(array $ids): array
    {
        return array_map(
            TimeSlotData::fromArray(...),
            $this->whereIn('id', $ids)->orderBy('start_time')->findAll(),
        );
    }
}
