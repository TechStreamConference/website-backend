<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\GlobalsModel;
use App\Models\MediaPartnerModel;
use App\Models\SocialMediaLinkModel;
use App\Models\SpeakerModel;
use App\Models\SponsorModel;
use App\Models\TalkModel;
use App\Models\TeamMemberModel;

class Event extends BaseController
{
    public function get(int|null $year = null) {
        $eventModel = new EventModel();
        if ($year === null) {
            $event = $eventModel->getLatestPublished();
            $year = intval(date('Y', strtotime($event['start_date'])));
        } else {
            $event = $eventModel->getPublishedByYear($year);
        }
        if ($event === null) {
            return $this->response->setStatusCode(404);
        }
        $eventId = $event['id'];

        $sponsorModel = new SponsorModel();
        $sponsors = $sponsorModel->getPublished($eventId);

        $mediaPartnerModel = new MediaPartnerModel();
        $mediaPartners = $mediaPartnerModel->getPublished($eventId);

        $talksModel = new TalkModel();
        $talks = $talksModel->getByEventId($eventId);

        $speakerModel = new SpeakerModel();
        $speakers = $speakerModel->getPublished($eventId);
        $speakerUserIds = array_column($speakers, 'user_id');

        $teamMemberModel = new TeamMemberModel();
        $teamMembers = $teamMemberModel->getPublished($eventId);
        $teamMemberUserIds = array_column($teamMembers, 'user_id');

        $socialMediaLinkModel = new SocialMediaLinkModel();
        $speakersSocialMediaLinks = $socialMediaLinkModel->get_approved_by_user_ids($speakerUserIds);
        $teamMembersSocialMediaLinks = $socialMediaLinkModel->get_approved_by_user_ids($teamMemberUserIds);

        foreach ($speakers as &$speaker) {
            $speaker['social_media_links'] = $speakersSocialMediaLinks[$speaker['user_id']] ?? [];
        }

        foreach ($teamMembers as &$teamMember) {
            $teamMember['social_media_links'] = $teamMembersSocialMediaLinks[$teamMember['user_id']] ?? [];
        }

        $event['year'] = $year;

        foreach ($speakers as &$speaker) {
            unset($speaker['user_id']);
        }

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

    public function getICalendarFile(int $year) {
        $eventModel = new EventModel();
        $event      = $eventModel->getPublishedByYear($year);
        if ($event === null) {
            // the requested year doesn't have an event
            return $this->response->setStatusCode(404);
        }

        $talkModel = new TalkModel();
        $talks     = $talkModel->getByEventId($event['id']);

        // Generate ICS file content
        $icsContent  = "BEGIN:VCALENDAR\n";
        $icsContent .= "VERSION:2.0\n";
        $icsContent .= "CALSCALE:GREGORIAN\n";

        foreach ($talks as $talk) {
            $icsContent .= "BEGIN:VEVENT\n";
            $icsContent .= "SUMMARY:" . $talk['title'] . "\n";
            $icsContent .= "DTSTART:" . date("Ymd\THis\Z", strtotime($talk['starts_at'])) . "\n";
            $icsContent .= "DTEND:" . date("Ymd\THis\Z", strtotime($talk['starts_at']) + ($talk['duration'] * 60) ) . "\n";
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
}
