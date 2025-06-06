<?php

namespace App\Controllers;

use App\Helpers\TimeSlotData;
use App\Models\EventModel;
use App\Models\TalkModel;
use App\Models\TimeSlotModel;
use CodeIgniter\HTTP\ResponseInterface;

class TimeSlot extends BaseController
{
    private const TIME_SLOT_RULES = [
        'time_slots.*.start_time' => 'required|valid_date[Y-m-d H:i:s]',
        'time_slots.*.duration' => 'required|is_natural_no_zero',
        // We cannot use `required` for `is_special` because the `required`
        // validator returns false if the value is false.
        'time_slots.*.is_special' => 'field_exists|is_bool',
    ];

    public function create_or_replace(int $eventId): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        if (!$this->validateData($data ?? [], self::TIME_SLOT_RULES)) {
            return $this
                ->response
                ->setJSON($this->validator->getErrors())
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $validData = $this->validator->getValidated();

        $eventModel = model(EventModel::class);
        $event = $eventModel->get($eventId);
        if ($event === null) {
            return $this
                ->response
                ->setJSON(['error' => 'EVENT_NOT_FOUND'])
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $timeSlotModel = model(TimeSlotModel::class);

        $timeSlots = array_map(
            static function (array $slot) use ($eventId) {
                return TimeSlotData::make(
                    $eventId,
                    $slot['start_time'],
                    $slot['duration'],
                    $slot['is_special'],
                );
            },
            $validData['time_slots'],
        );

        $validationResult = $this->areTimeSlotsValid($timeSlots, $event);
        if ($validationResult !== true) {
            return $validationResult;
        }

        if (!$timeSlotModel->deleteAllOfEvent($eventId)) {
            return $this
                ->response
                ->setJSON(['error' => 'CANNOT_DELETE_ASSIGNED_TIME_SLOTS'])
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        if (!$timeSlotModel->store($timeSlots)) {
            // This happens when trying to store new time slots, even though there already are talks
            // that have been assigned to time slots (violation of foreign key constraint).
            return $this
                ->response
                ->setJSON(['error' => 'FAILED_TO_STORE_TIME_SLOTS'])
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this
            ->response
            ->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
    }

    public function get(int $eventId): ResponseInterface
    {
        $eventModel = model(EventModel::class);
        if (!$eventModel->doesExist($eventId)) {
            return $this
                ->response
                ->setJSON(['error' => 'EVENT_NOT_FOUND'])
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $timeSlotModel = model(TimeSlotModel::class);
        $timeSlots = $timeSlotModel->getByEventId($eventId);

        $talkModel = model(TalkModel::class);
        $timeSlotsArray = array_map(
            function($timeSlot) use ($talkModel) {
                $data = $timeSlot->toArray();
                // Check if the time slot is occupied by looking for a talk with this `time_slot_id`.
                $talk = $talkModel->findByTimeSlot($timeSlot->id);
                $data['is_occupied'] = ($talk !== null);
                return $data;
            },
            $timeSlots,
        );
        return $this->response->setJSON($timeSlotsArray);
    }

    /**
     * Checks whether the given time slots are valid (i.e., they don't overlap with each other and they don't
     * exceed the event's duration).
     * @param TimeSlotData[] $timeSlots The time slots to check.
     * @param array $event The event data.
     * @return true|ResponseInterface True if the time slots are valid, a ResponseInterface object otherwise.
     */
    private function areTimeSlotsValid(array $timeSlots, array $event): true|ResponseInterface
    {
        // Do they overlap?
        if ($this->doOverlap($timeSlots)) {
            return $this
                ->response
                ->setJSON(['error' => 'TIME_SLOTS_OVERLAP'])
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Do they exceed the event's duration?
        $eventStart = strtotime($event['start_date']);
        $eventEnd = strtotime($event['end_date'] . " + 1 day - 1 second");
        foreach ($timeSlots as $timeSlot) {
            if (!$this->isWithinTimeFrame($timeSlot, $eventStart, $eventEnd)) {
                return $this
                    ->response
                    ->setJSON(['error' => 'TIME_SLOT_OUTSIDE_EVENT_DURATION'])
                    ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
            }
        }

        return true;
    }

    /**
     * Checks whether the given time slots overlap with each other.
     * @param TimeSlotData[] $timeSlots
     * @return bool True if the time slots overlap, false otherwise.
     */
    private function doOverlap(array $timeSlots): bool
    {
        // This has quadratic runtime complexity, but it's fine because the number of time slots is small.
        $n = count($timeSlots);
        for ($i = 0; $i < $n - 1; ++$i) {
            for ($j = $i + 1; $j < $n; ++$j) {
                if ($this->overlaps($timeSlots[$i], $timeSlots[$j])) {
                    return true;
                }
            }
        }
        return false;
    }

    private function overlaps(TimeSlotData $a, TimeSlotData $b): bool
    {
        $startA = strtotime($a->startTime);
        $endA = $startA + $a->duration * 60;
        $startB = strtotime($b->startTime);
        $endB = $startB + $b->duration * 60;
        return $startA < $endB && $startB < $endA;
    }

    private function isWithinTimeFrame(
        TimeSlotData $timeSlot,
        int          $start,
        int          $end,
    ): bool
    {
        $timeSlotStart = strtotime($timeSlot->startTime);
        $timeSlotEnd = strtotime($timeSlot->startTime . "+ $timeSlot->duration minutes");

        return $timeSlotStart >= $start && $timeSlotEnd <= $end;
    }
}
