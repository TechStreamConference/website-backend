<?php

namespace App\Controllers;

use App\Helpers\Role;
use App\Helpers\TimeSlotData;
use App\Models\EventModel;
use App\Models\GuestModel;
use App\Models\MediaPartnerModel;
use App\Models\SocialMediaLinkModel;
use App\Models\SpeakerModel;
use App\Models\SponsorModel;
use App\Models\TagModel;
use App\Models\TalkModel;
use App\Models\TeamMemberModel;
use App\Models\TimeSlotModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use DateTimeZone;
use InvalidArgumentException;

class Event extends BaseController
{
    public function get(int|null $year = null): ResponseInterface
    {
        $eventModel = model(EventModel::class);
        if ($year === null) {
            $event = $eventModel->getLatestPublished();
            if ($event === null) {
                return $this
                    ->response
                    ->setJSON(['error' => 'NO_PUBLISHED_EVENT'])
                    ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            }
            $year = (int)date('Y', strtotime($event['start_date']));
        } else {
            $event = $eventModel->getPublishedByYear($year);
        }
        if ($event === null) {
            return $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        $eventId = $event['id'];

        $sponsorModel = model(SponsorModel::class);
        $sponsors = $sponsorModel->getPublished($eventId);

        $mediaPartnerModel = model(MediaPartnerModel::class);
        $mediaPartners = $mediaPartnerModel->getPublished($eventId);

        $speakers = $this->getPublishedContributors($eventId, Role::SPEAKER);
        $teamMembers = $this->getPublishedContributors($eventId, Role::TEAM_MEMBER);

        $scheduleVisibleFrom = $event['schedule_visible_from'];
        if ($scheduleVisibleFrom === null || $scheduleVisibleFrom > date('Y-m-d H:i:s')) {
            $talks = [];
        } else {
            $talks = $this->getVisibleApprovedTalks($eventId, $speakers);
        }

        $event['year'] = $year;

        foreach ($teamMembers as &$teamMember) {
            unset($teamMember['user_id']);
        }

        $this->addFrontpageVisibilityInformation($event);

        return $this->response->setJSON([
            'event' => $event,
            'speakers' => $speakers,
            'team_members' => $teamMembers,
            'sponsors' => $sponsors,
            'media_partners' => $mediaPartners,
            'talks' => $talks,
        ]);
    }

    public function getICalendarFile(int $year): ResponseInterface
    {
        $eventModel = new EventModel();
        $event = $eventModel->getPublishedByYear($year);
        if ($event === null) {
            // the requested year doesn't have an event
            return $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $speakers = $this->getPublishedContributors($event['id'], Role::SPEAKER);

        $talks = $this->getVisibleApprovedTalks($event['id'], $speakers);

        // Generate ICS file content
        $icsContent = "BEGIN:VCALENDAR\r\n";
        $icsContent .= "VERSION:2.0\r\n";
        $icsContent .= "PRODID:-//TECH STREAM CONFERENCE//Test-Conf//DE\r\n";
        $icsContent .= "CALSCALE:GREGORIAN\r\n";


        foreach ($talks as $talk) {
            // Find the speaker for this talk based on their user_id.
            $speaker = current(array_filter($speakers, fn($speaker) => $speaker['id'] === $talk['speaker_id']));
            $icsContent .= "BEGIN:VEVENT\r\n";
            $icsContent .= "SUMMARY:{$speaker['name']} | {$talk['title']}\r\n";
            $icsContent .= "DTSTART:" . $this->germanToUtcTime($talk['starts_at']) . "\r\n";
            $icsContent .= "DTEND:" . $this->germanToUtcTime(date("Y-m-d H:i:s", strtotime($talk['starts_at']) + ($talk['duration'] * 60))) . "\r\n";
            $icsContent .= "LOCATION:" . $event['twitch_url'] . "\r\n";
            $icsContent .= "DESCRIPTION:" . str_replace("\r", '', str_replace("\n", '\n', $talk['description'])) . "\r\n";
            $icsContent .= "UID:" . md5($talk['id']) . "\r\n";
            $icsContent .= "DTSTAMP:" . $this->germanToUtcTime(date("Ymd\THis\Z")) . "\r\n";
            $icsContent .= "STATUS:CONFIRMED\r\n";
            $icsContent .= "TRANSP:OPAQUE\r\n";
            $icsContent .= "URL:" . $event['twitch_url'] . "\r\n";
            $icsContent .= "END:VEVENT\r\n";
        }

        $icsContent .= "END:VCALENDAR\r\n";

        $filename = 'test-conf-' . $year . '.ics';

        return $this->response
            ->setHeader('Content-Type', 'text/calendar; charset=utf-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Content-Length', strlen($icsContent))
            ->setBody($icsContent);
    }

    private function germanToUtcTime(string $germanTime): string
    {
        $dateInGermany = new DateTime($germanTime, new DateTimeZone('Europe/Berlin'));
        $dateInGermany->setTimezone(new DateTimeZone('UTC'));
        return $dateInGermany->format('Ymd\THis\Z');
    }

    private function getVisibleApprovedTalks(int $eventId, array $speakers): array
    {
        $talkModel = model(TalkModel::class);
        $talks = $talkModel->getApprovedByEventId($eventId);
        $talkIds = array_column($talks, 'id');

        $timeSlotById = $this->getTimeSlotMapping(array_column($talks, 'time_slot_id'));

        $this->addGuestsToTalks($talks, $speakers);

        $tagModel = model(TagModel::class);
        $tagMapping = $tagModel->getTagMapping($talkIds);

        foreach ($talks as &$talk) {
            $timeSlot = $timeSlotById[$talk['time_slot_id']];
            $talk['starts_at'] = $timeSlot->startTime;
            $talk['duration'] = $timeSlot->duration;
            $talk['is_special'] = $timeSlot->isSpecial;
            $talk['tags'] = $tagMapping[$talk['id']];
        }

        usort($talks, fn($a, $b) => $a['starts_at'] <=> $b['starts_at']);

        return $talks;
    }

    private function addFrontpageVisibilityInformation(array &$event): void
    {
        $now = date('Y-m-d H:i:s');
        $event['is_visible_on_frontpage'] = $event['frontpage_date'] <= $now;
    }

    /**
     * @param int[] $timeSlotIds
     * @return TimeSlotData[]
     */
    private function getTimeSlotMapping(array $timeSlotIds): array
    {
        $timeSlotModel = model(TimeSlotModel::class);
        $timeSlots = $timeSlotModel->getByIds($timeSlotIds);
        $timeSlotById = [];
        foreach ($timeSlots as $timeSlot) {
            $timeSlotById[$timeSlot->id] = $timeSlot;
        }
        return $timeSlotById;
    }

    private function getPublishedContributors(int $eventId, Role $role): array
    {
        $model = match ($role) {
            Role::SPEAKER => model(SpeakerModel::class),
            Role::TEAM_MEMBER => model(TeamMemberModel::class),
            default => throw new InvalidArgumentException('Invalid role'),
        };

        $contributors = $model->getPublished($eventId);
        $userIds = array_column($contributors, 'user_id');

        $socialMediaLinkModel = model(SocialMediaLinkModel::class);
        $socialMediaLinks = $socialMediaLinkModel->getLatestApprovedByUserIds($userIds);

        foreach ($contributors as &$contributor) {
            $contributor['social_media_links'] = $socialMediaLinks[$contributor['user_id']] ?? [];
        }

        return $contributors;
    }
}
