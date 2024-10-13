<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\MediaPartnerModel;
use App\Models\SocialMediaLinkModel;
use App\Models\SpeakerModel;
use App\Models\SponsorModel;
use App\Models\TalkModel;
use App\Models\TeamMemberModel;

class Event extends BaseController
{
    public function get(int|null $year = null) {
        if ($year === null) {
            // todo: fetch the currently displayed year from the database
            $year = 2024;
        }
        $eventModel = new EventModel();
        $event = $eventModel->getByYear($year);
        $eventId = $event['id'];
        if ($event === null) {
            return $this->response->setStatusCode(404);
        }

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
        $speakersSocialMediaLinks = $socialMediaLinkModel->get_by_user_ids($speakerUserIds);
        $teamMembersSocialMediaLinks = $socialMediaLinkModel->get_by_user_ids($teamMemberUserIds);

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
}
