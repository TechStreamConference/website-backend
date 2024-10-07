<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\SocialMediaLinkModel;
use App\Models\SocialMediaTypeModel;
use App\Models\SpeakerModel;

class Event extends BaseController
{
    public function get(int|null $year = null) {
        if ($year === null) {
            // todo: fetch the currently displayed year from the database
            $year = 2024;
        }
        $eventModel = new EventModel();
        $event = $eventModel->getByYear($year);
        if ($event === null) {
            return $this->response->setStatusCode(404);
        }

        $speakerModel = new SpeakerModel();
        $speakers = $speakerModel->getPublished($event['id']);
        $userIds = array_column($speakers, 'user_id');

        $socialMediaLinkModel = new SocialMediaLinkModel();
        $socialMediaLinks = $socialMediaLinkModel->get_by_user_ids($userIds);

        foreach ($speakers as &$speaker) {
            $speaker['social_media_links'] = $socialMediaLinks[$speaker['user_id']] ?? [];
        }

        $event['year'] = $year;

        return $this->response->setJSON([
            'event' => $event,
            'speakers' => $speakers,
        ]);
    }
}
