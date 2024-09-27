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

        $socialMediaTypeModel = new SocialMediaTypeModel();
        $socialMediaTypes = $socialMediaTypeModel->all();

        $socialMediaLinkModel = new SocialMediaLinkModel();
        foreach ($speakers as &$speaker) {
            $dbLinks = $socialMediaLinkModel->get_by_speaker_id($speaker['id']);
            $links = [];
            foreach ($dbLinks as $dbLink) {
                $typeId = $dbLink['social_media_type_id'];
                if (!isset($socialMediaTypes[$typeId])) {
                    return $this->response->setStatusCode(500);
                }
                $type = $socialMediaTypes[$typeId];
                $links[] = [
                    'type' => $type['name'],
                    'url' => $dbLink['url'],
                ];
            }
            $speaker['social_media_links'] = $links;
        }

        $event['year'] = $year;

        return $this->response->setJSON([
            'event' => $event,
            'speakers' => $speakers,
        ]);
    }
}
