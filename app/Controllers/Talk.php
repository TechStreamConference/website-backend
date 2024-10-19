<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TalkModel;
use App\Models\EventModel;

class Talk extends BaseController
{
    public function getICS($year) {
        // Start output buffering
        ob_start();

        // Get event id by year
        $eventModel = new EventModel();
        $event      = $eventModel->getByYear($year);

        // Get all event talks
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

        // Clean output buffer and end buffering
        ob_end_clean();

        // Set filename
        $filename = 'test-conf-' . $year . '.ics';

        // Set headers and return ICS file
        return $this->response
            ->setHeader('Content-Type', 'text/calendar; charset=utf-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Content-Length', strlen($icsContent))
            ->setBody($icsContent);
    }
}
