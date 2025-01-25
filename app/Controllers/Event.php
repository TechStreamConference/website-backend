<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\Role;
use App\Helpers\TimeSlotData;
use App\Models\EventModel;
use App\Models\GlobalsModel;
use App\Models\MediaPartnerModel;
use App\Models\SocialMediaLinkModel;
use App\Models\SpeakerModel;
use App\Models\SponsorModel;
use App\Models\TagModel;
use App\Models\TalkModel;
use App\Models\TeamMemberModel;
use App\Models\TimeSlotModel;
use CodeIgniter\HTTP\ResponseInterface;
use InvalidArgumentException;

class Event extends BaseController
{
    public function get(int|null $year = null): ResponseInterface
    {
        $eventModel = model(EventModel::class);
        if ($year === null) {
            $event = $eventModel->getLatestPublished();
            $year = (int)date('Y', strtotime($event['start_date']));
        } else {
            $event = $eventModel->getPublishedByYear($year);
        }
        if ($event === null) {
            return $this->response->setStatusCode(404);
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

        return $this->response->setJSON([
            'event' => $event,
            'speakers' => $speakers,
            'team_members' => $teamMembers,
            'sponsors' => $sponsors,
            'media_partners' => $mediaPartners,
            'talks' => $talks,
        ]);
    }

    public function getICalendarFile(int $year)
    {
        $eventModel = new EventModel();
        $event = $eventModel->getPublishedByYear($year);
        if ($event === null) {
            // the requested year doesn't have an event
            return $this->response->setStatusCode(404);
        }

        $talks = $this->getVisibleApprovedTalks($event['id'], $this->getPublishedContributors($event['id'], Role::SPEAKER));

        // Generate ICS file content
        $icsContent = "BEGIN:VCALENDAR\n";
        $icsContent .= "VERSION:2.0\n";
        $icsContent .= "CALSCALE:GREGORIAN\n";

        foreach ($talks as $talk) {
            $icsContent .= "BEGIN:VEVENT\n";
            $icsContent .= "SUMMARY:" . $talk['title'] . "\n";
            $icsContent .= "DTSTART:" . date("Ymd\THis\Z", strtotime($talk['starts_at'])) . "\n";
            $icsContent .= "DTEND:" . date("Ymd\THis\Z", strtotime($talk['starts_at']) + ($talk['duration'] * 60)) . "\n";
            $icsContent .= "LOCATION:" . $event['twitch_url'] . "\n";
            $icsContent .= "DESCRIPTION:" . $talk['description'] . "\n";
            $icsContent .= "END:VEVENT\n";
        }

        $icsContent .= "END:VCALENDAR\n";

        $filename = 'test-conf-' . $year . '.ics';

        return $this->response
            ->setHeader('Content-Type', 'text/calendar; charset=utf-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Content-Length', strlen($icsContent))
            ->setBody($icsContent);
    }

    private function getVisibleApprovedTalks(int $eventId, array $speakers): array
    {
        $talkModel = model(TalkModel::class);
        $talks = $talkModel->getApprovedByEventId($eventId);
        $talkIds = array_column($talks, 'id');

        $timeSlotById = $this->getTimeSlotMapping(array_column($talks, 'time_slot_id'));

        /* @var array<int, array> $speakerById */
        $speakerById = [];

        foreach ($talks as &$talk) {
            // Find the speaker for this talk based on their user_id.
            $talk['speaker_id'] = null;
            unset($speaker);
            foreach ($speakers as $speaker) {
                if ($speaker['user_id'] === $talk['user_id']) {
                    $talk['speaker_id'] = $speaker['id'];
                    $speakerById[$speaker['id']] = $speaker;
                    break;
                }
            }
        }
        unset($talk);

        $talks = array_filter(
            $talks,
            fn ($talk) => $talk['speaker_id'] !== null
        );

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
