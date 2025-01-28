<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use App\Database\Seeds\MainSeeder;

class ApprovalTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh = true;
    protected $namespace = null; // run all migrations from all available namespaces (like php spark migrate --all)

    protected $seed = MainSeeder::class;
    protected $seedOnce = false;
    protected $basePath = 'app/Database';

    // *******************************
    // getPendingRoleEntries()
    // *******************************
    public function testGetPendingRoleEntries_returnsPendingRoleEntries(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->get('dashboard/admin/approval/speaker');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                "id" => 3,
                "name" => "coder4k",
                "user_id" => 1,
                "event_id" => 1,
                "short_bio" => "Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner",
                "bio" => "Michael (coder2k) hat vor über 20 Jahren 'Turbo Pascal und Delphi für Kids' gelesen und sich seitdem mit dem Programmieren in verschiedenen Programmiersprachen beschäftigt. Er ist tätig als Software-Entwickler im Embedded-Umfeld und freier Dozent. Seit drei Jahren programmiert er auch auf Twitch und ist seit Anfang 2024 Twitch-Partner. Michael ist es wichtig, Wissen mit anderen auszutauschen und sich dadurch gemeinsam weiterzuentwickeln und neue Dinge zu lernen – und daraus ist auch die Idee zur Test-Conf entstanden.",
                "photo" => "coder2k.jpg",
                "photo_mime_type" => "image/jpeg",
                "visible_from" => "2024-06-01 15:00:00",
                "requested_changes" => null,
                "account" => [
                    "username" => "coder2k",
                    "email" => "coder2k@test-conf.de",
                ],
                "event" => [
                    "id" => 1,
                    "title" => "Tech Stream Conference 2024",
                    "subtitle" => "Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.",
                    "start_date" => "2024-06-22",
                    "end_date" => "2024-06-23",
                    "discord_url" => "https://discord.com/invite/tp4EnphfKb",
                    "twitch_url" => "https://www.twitch.tv/coder2k",
                    "presskit_url" => "https://test-conf.de/Test-Conf-Presskit.zip",
                    "trailer_youtube_id" => "IW1vQAB6B18",
                    "description_headline" => "Sei dabei!",
                    "description" => "Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.\nWir möchten dich herzlich einladen, an unserer ersten Online-Konferenz teilzunehmen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen. Also sei gespannt!",
                    "schedule_visible_from" => "2024-06-10 12:00:00",
                    "publish_date" => "2024-01-01 12:00:00",
                    "call_for_papers_start" => "2023-12-01 12:00:00",
                    "call_for_papers_end" => "2030-03-01 12:00:00",
                ],
                "diff" => [
                    "name",
                ],
            ],
            [
                "account" => [
                    "email" => "coder2k@test-conf.de",
                    "username" => "coder2k"
                ],
                "bio" => "Auch 2025 noch ein geiler Typ.",
                "diff" => [
                    "name"
                ],
                "event" => [
                    "call_for_papers_end" => null,
                    "call_for_papers_start" => null,
                    "description" => "In einer weit, weit entfernten Galaxis...\nDie Tech Stream Conference 2025 steht unter dem Motto \"Das Imperium schlägt zurück!\".\nSei dabei, wenn wir die dunkle Seite der Macht beleuchten und uns mit den dunklen Machenschaften der Technik beschäftigen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen.\nAlso sei gespannt!",
                    "description_headline" => "Komm' ran!",
                    "discord_url" => "https://discord.com/invite/tp4EnphfKb",
                    "end_date" => "2025-06-23",
                    "id" => 2,
                    "presskit_url" => "https://test-conf.de/Test-Conf-Presskit.zip",
                    "publish_date" => null,
                    "schedule_visible_from" => "2025-06-22 12:00:00",
                    "start_date" => "2025-06-22",
                    "subtitle" => "Das Imperium schlägt zurück!",
                    "title" => "Tech Stream Conference 2025",
                    "trailer_youtube_id" => "IW1vQAB6B18",
                    "twitch_url" => "https://www.twitch.tv/coder2k"
                ],
                "event_id" => 2,
                "id" => 7,
                "name" => "coder2k",
                "photo" => "coder2k.jpg",
                "photo_mime_type" => "image/jpeg",
                "requested_changes" => null,
                "short_bio" => "Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner, auch 2025 wieder dabei!",
                "user_id" => 1,
                "visible_from" => "2025-06-01 15:00:00"
            ]
        ]);
    }

    // *******************************
    // approveRoleEntry()
    // *******************************
    public function testApproveRoleEntry_approvesRoleEntry(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->put('dashboard/admin/approval/speaker/3');
        $response->assertStatus(204);

        // Check if the entry was approved (pending entry has gone).
        $response = $this
            ->withSession($sessionValues)
            ->get('dashboard/admin/approval/speaker');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                "account" => [
                    "email" => "coder2k@test-conf.de",
                    "username" => "coder2k"
                ],
                "bio" => "Auch 2025 noch ein geiler Typ.",
                "diff" => [
                    "name"
                ],
                "event" => [
                    "call_for_papers_end" => null,
                    "call_for_papers_start" => null,
                    "description" => "In einer weit, weit entfernten Galaxis...
Die Tech Stream Conference 2025 steht unter dem Motto \"Das Imperium schlägt zurück!\".
Sei dabei, wenn wir die dunkle Seite der Macht beleuchten und uns mit den dunklen Machenschaften der Technik beschäftigen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen.
Also sei gespannt!",
                    "description_headline" => "Komm' ran!",
                    "discord_url" => "https://discord.com/invite/tp4EnphfKb",
                    "end_date" => "2025-06-23",
                    "id" => 2,
                    "presskit_url" => "https://test-conf.de/Test-Conf-Presskit.zip",
                    "publish_date" => null,
                    "schedule_visible_from" => "2025-06-22 12:00:00",
                    "start_date" => "2025-06-22",
                    "subtitle" => "Das Imperium schlägt zurück!",
                    "title" => "Tech Stream Conference 2025",
                    "trailer_youtube_id" => "IW1vQAB6B18",
                    "twitch_url" => "https://www.twitch.tv/coder2k"
                ],
                "event_id" => 2,
                "id" => 7,
                "name" => "coder2k",
                "photo" => "coder2k.jpg",
                "photo_mime_type" => "image/jpeg",
                "requested_changes" => null,
                "short_bio" => "Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner, auch 2025 wieder dabei!",
                "user_id" => 1,
                "visible_from" => "2025-06-01 15:00:00"
            ]
        ]);
    }

    public function testApproveRoleEntry_doesNotApproveApprovedRoleEntry(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->put('dashboard/admin/approval/speaker/1');
        $response->assertStatus(400);
    }

    public function testApproveRoleEntry_doesNotApproveNonExistingRoleEntry(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->put('dashboard/admin/approval/speaker/999');
        $response->assertStatus(400);
    }

    // *******************************
    // getPendingSpeakers()
    // *******************************
    public function testGetPendingSpeakers_returnsPendingSpeakers(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->get('dashboard/admin/approval/speaker');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                "id" => 3,
                "name" => "coder4k",
                "user_id" => 1,
                "event_id" => 1,
                "short_bio" => "Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner",
                "bio" => "Michael (coder2k) hat vor über 20 Jahren 'Turbo Pascal und Delphi für Kids' gelesen und sich seitdem mit dem Programmieren in verschiedenen Programmiersprachen beschäftigt. Er ist tätig als Software-Entwickler im Embedded-Umfeld und freier Dozent. Seit drei Jahren programmiert er auch auf Twitch und ist seit Anfang 2024 Twitch-Partner. Michael ist es wichtig, Wissen mit anderen auszutauschen und sich dadurch gemeinsam weiterzuentwickeln und neue Dinge zu lernen – und daraus ist auch die Idee zur Test-Conf entstanden.",
                "photo" => "coder2k.jpg",
                "photo_mime_type" => "image/jpeg",
                "visible_from" => "2024-06-01 15:00:00",
                "requested_changes" => null,
                "account" => [
                    "username" => "coder2k",
                    "email" => "coder2k@test-conf.de",
                ],
                "event" => [
                    "id" => 1,
                    "title" => "Tech Stream Conference 2024",
                    "subtitle" => "Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.",
                    "start_date" => "2024-06-22",
                    "end_date" => "2024-06-23",
                    "discord_url" => "https://discord.com/invite/tp4EnphfKb",
                    "twitch_url" => "https://www.twitch.tv/coder2k",
                    "presskit_url" => "https://test-conf.de/Test-Conf-Presskit.zip",
                    "trailer_youtube_id" => "IW1vQAB6B18",
                    "description_headline" => "Sei dabei!",
                    "description" => "Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.\nWir möchten dich herzlich einladen, an unserer ersten Online-Konferenz teilzunehmen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen. Also sei gespannt!",
                    "schedule_visible_from" => "2024-06-10 12:00:00",
                    "publish_date" => "2024-01-01 12:00:00",
                    "call_for_papers_start" => "2023-12-01 12:00:00",
                    "call_for_papers_end" => "2030-03-01 12:00:00",
                ],
                "diff" => [
                    "name",
                ],
            ],
            [
                "account" => [
                    "email" => "coder2k@test-conf.de",
                    "username" => "coder2k"
                ],
                "bio" => "Auch 2025 noch ein geiler Typ.",
                "diff" => [
                    "name"
                ],
                "event" => [
                    "call_for_papers_end" => null,
                    "call_for_papers_start" => null,
                    "description" => "In einer weit, weit entfernten Galaxis...
Die Tech Stream Conference 2025 steht unter dem Motto \"Das Imperium schlägt zurück!\".
Sei dabei, wenn wir die dunkle Seite der Macht beleuchten und uns mit den dunklen Machenschaften der Technik beschäftigen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen.
Also sei gespannt!",
                    "description_headline" => "Komm' ran!",
                    "discord_url" => "https://discord.com/invite/tp4EnphfKb",
                    "end_date" => "2025-06-23",
                    "id" => 2,
                    "presskit_url" => "https://test-conf.de/Test-Conf-Presskit.zip",
                    "publish_date" => null,
                    "schedule_visible_from" => "2025-06-22 12:00:00",
                    "start_date" => "2025-06-22",
                    "subtitle" => "Das Imperium schlägt zurück!",
                    "title" => "Tech Stream Conference 2025",
                    "trailer_youtube_id" => "IW1vQAB6B18",
                    "twitch_url" => "https://www.twitch.tv/coder2k"
                ],
                "event_id" => 2,
                "id" => 7,
                "name" => "coder2k",
                "photo" => "coder2k.jpg",
                "photo_mime_type" => "image/jpeg",
                "requested_changes" => null,
                "short_bio" => "Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner, auch 2025 wieder dabei!",
                "user_id" => 1,
                "visible_from" => "2025-06-01 15:00:00"
            ]
        ]);
    }

    // *******************************
    // approveSpeaker()
    // *******************************
    public function testApproveSpeaker_approvesSpeaker(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->put('dashboard/admin/approval/speaker/3');
        $response->assertStatus(204);

        // Check if the speaker was approved (pending speaker has gone).
        $response = $this
            ->withSession($sessionValues)
            ->get('dashboard/admin/approval/speaker');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                "account" => [
                    "email" => "coder2k@test-conf.de",
                    "username" => "coder2k"
                ],
                "bio" => "Auch 2025 noch ein geiler Typ.",
                "diff" => [
                    "name"
                ],
                "event" => [
                    "call_for_papers_end" => null,
                    "call_for_papers_start" => null,
                    "description" => "In einer weit, weit entfernten Galaxis...
Die Tech Stream Conference 2025 steht unter dem Motto \"Das Imperium schlägt zurück!\".
Sei dabei, wenn wir die dunkle Seite der Macht beleuchten und uns mit den dunklen Machenschaften der Technik beschäftigen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen.
Also sei gespannt!",
                    "description_headline" => "Komm' ran!",
                    "discord_url" => "https://discord.com/invite/tp4EnphfKb",
                    "end_date" => "2025-06-23",
                    "id" => 2,
                    "presskit_url" => "https://test-conf.de/Test-Conf-Presskit.zip",
                    "publish_date" => null,
                    "schedule_visible_from" => "2025-06-22 12:00:00",
                    "start_date" => "2025-06-22",
                    "subtitle" => "Das Imperium schlägt zurück!",
                    "title" => "Tech Stream Conference 2025",
                    "trailer_youtube_id" => "IW1vQAB6B18",
                    "twitch_url" => "https://www.twitch.tv/coder2k"
                ],
                "event_id" => 2,
                "id" => 7,
                "name" => "coder2k",
                "photo" => "coder2k.jpg",
                "photo_mime_type" => "image/jpeg",
                "requested_changes" => null,
                "short_bio" => "Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner, auch 2025 wieder dabei!",
                "user_id" => 1,
                "visible_from" => "2025-06-01 15:00:00"
            ]
        ]);
    }

    public function testApproveSpeaker_doesNotApproveApprovedSpeaker(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->put('dashboard/admin/approval/speaker/1');
        $response->assertStatus(400);
    }

    public function testApproveSpeaker_doesNotApproveNonExistingSpeaker(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->put('dashboard/admin/approval/speaker/999');
        $response->assertStatus(400);
    }

    // *******************************
    // getPendingTeamMembers()
    // *******************************
    public function testGetPendingTeamMembers_returnsPendingTeamMembers(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->get('dashboard/admin/approval/team-member');
        $response->assertStatus(200);
        $response->assertJSONExact([]);
    }

    // *******************************
    // getPendingSocialMediaLinks()
    // *******************************
    public function testGetPendingSocialMediaLinks_returnsPendingSocialMediaLinks(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->get('dashboard/admin/approval/social-media-link');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                "id" => 2,
                "user_id" => 1,
                "name" => "GitHub",
                "url" => "https://www.github.com/mgerhold",
                "requested_changes" => null,
                "account" => [
                    "username" => "coder2k",
                    "email" => "coder2k@test-conf.de",
                ],
            ],
        ]);
    }

    // *******************************
    // approveSocialMediaLink()
    // *******************************
    public function testApproveSocialMediaLink_approvesSocialMediaLink(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->put('dashboard/admin/approval/social-media-link/2');
        $response->assertStatus(204);

        // Check if the social media link was approved (pending social media link has gone).
        $response = $this
            ->withSession($sessionValues)
            ->get('dashboard/admin/approval/social-media-link');
        $response->assertStatus(200);
        $response->assertJSONExact([]);
    }

    public function testApproveSocialMediaLink_doesNotApproveApprovedSocialMediaLink(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->put('dashboard/admin/approval/social-media-link/1');
        $response->assertStatus(400);
    }

    public function testApproveSocialMediaLink_doesNotApproveNonExistingSocialMediaLink(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->put('dashboard/admin/approval/social-media-link/999');
        $response->assertStatus(400);
    }

    // *******************************
    // requestChangesForSpeaker()
    // *******************************
    public function testRequestChangesForSpeaker_requestsChangesForSpeaker(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put(
                'dashboard/admin/approval/speaker/3/request-changes',
                [
                    'message' => 'There is a typo in the username.',
                ]
            );
        $response->assertStatus(204);

        // Check that the message is now included in the pending entry.
        $response = $this
            ->withSession($sessionValues)
            ->get('dashboard/admin/approval/speaker');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                "id" => 3,
                "name" => "coder4k",
                "user_id" => 1,
                "event_id" => 1,
                "short_bio" => "Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner",
                "bio" => "Michael (coder2k) hat vor über 20 Jahren 'Turbo Pascal und Delphi für Kids' gelesen und sich seitdem mit dem Programmieren in verschiedenen Programmiersprachen beschäftigt. Er ist tätig als Software-Entwickler im Embedded-Umfeld und freier Dozent. Seit drei Jahren programmiert er auch auf Twitch und ist seit Anfang 2024 Twitch-Partner. Michael ist es wichtig, Wissen mit anderen auszutauschen und sich dadurch gemeinsam weiterzuentwickeln und neue Dinge zu lernen – und daraus ist auch die Idee zur Test-Conf entstanden.",
                "photo" => "coder2k.jpg",
                "photo_mime_type" => "image/jpeg",
                "visible_from" => "2024-06-01 15:00:00",
                "requested_changes" => "There is a typo in the username.",
                "account" => [
                    "username" => "coder2k",
                    "email" => "coder2k@test-conf.de",
                ],
                "event" => [
                    "id" => 1,
                    "title" => "Tech Stream Conference 2024",
                    "subtitle" => "Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.",
                    "start_date" => "2024-06-22",
                    "end_date" => "2024-06-23",
                    "discord_url" => "https://discord.com/invite/tp4EnphfKb",
                    "twitch_url" => "https://www.twitch.tv/coder2k",
                    "presskit_url" => "https://test-conf.de/Test-Conf-Presskit.zip",
                    "trailer_youtube_id" => "IW1vQAB6B18",
                    "description_headline" => "Sei dabei!",
                    "description" => "Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.\nWir möchten dich herzlich einladen, an unserer ersten Online-Konferenz teilzunehmen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen. Also sei gespannt!",
                    "schedule_visible_from" => "2024-06-10 12:00:00",
                    "publish_date" => "2024-01-01 12:00:00",
                    "call_for_papers_start" => "2023-12-01 12:00:00",
                    "call_for_papers_end" => "2030-03-01 12:00:00",
                ],
                "diff" => [
                    "name",
                ],
            ],
            [
                "account" => [
                    "email" => "coder2k@test-conf.de",
                    "username" => "coder2k"
                ],
                "bio" => "Auch 2025 noch ein geiler Typ.",
                "diff" => [
                    "name"
                ],
                "event" => [
                    "call_for_papers_end" => null,
                    "call_for_papers_start" => null,
                    "description" => "In einer weit, weit entfernten Galaxis...
Die Tech Stream Conference 2025 steht unter dem Motto \"Das Imperium schlägt zurück!\".
Sei dabei, wenn wir die dunkle Seite der Macht beleuchten und uns mit den dunklen Machenschaften der Technik beschäftigen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen.
Also sei gespannt!",
                    "description_headline" => "Komm' ran!",
                    "discord_url" => "https://discord.com/invite/tp4EnphfKb",
                    "end_date" => "2025-06-23",
                    "id" => 2,
                    "presskit_url" => "https://test-conf.de/Test-Conf-Presskit.zip",
                    "publish_date" => null,
                    "schedule_visible_from" => "2025-06-22 12:00:00",
                    "start_date" => "2025-06-22",
                    "subtitle" => "Das Imperium schlägt zurück!",
                    "title" => "Tech Stream Conference 2025",
                    "trailer_youtube_id" => "IW1vQAB6B18",
                    "twitch_url" => "https://www.twitch.tv/coder2k"
                ],
                "event_id" => 2,
                "id" => 7,
                "name" => "coder2k",
                "photo" => "coder2k.jpg",
                "photo_mime_type" => "image/jpeg",
                "requested_changes" => null,
                "short_bio" => "Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner, auch 2025 wieder dabei!",
                "user_id" => 1,
                "visible_from" => "2025-06-01 15:00:00"
            ]
        ]);
    }

    public function testRequestChangesForSpeaker_doesNotRequestChangesForApprovedSpeaker(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put(
                'dashboard/admin/approval/speaker/1/request-changes',
                [
                    'message' => 'There is a typo in the username.',
                ]
            );
        $response->assertStatus(400);
    }

    public function testRequestChangesForSpeaker_doesNotRequestChangesForNonExistingSpeaker(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put(
                'dashboard/admin/approval/speaker/999/request-changes',
                [
                    'message' => 'There is a typo in the username.',
                ]
            );
        $response->assertStatus(400);
    }

    // *******************************
    // requestChangesForSocialMediaLink()
    // *******************************
    public function testRequestChangesForSocialMediaLink_requestsChangesForSocialMediaLink(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put(
                'dashboard/admin/approval/social-media-link/2/request-changes',
                [
                    'message' => 'The URL is wrong.',
                ]
            );
        $response->assertStatus(204);

        // Check that the message is now included in the pending entry.
        $response = $this
            ->withSession($sessionValues)
            ->get('dashboard/admin/approval/social-media-link');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                "id" => 2,
                "user_id" => 1,
                "name" => "GitHub",
                "url" => "https://www.github.com/mgerhold",
                "requested_changes" => "The URL is wrong.",
                "account" => [
                    "username" => "coder2k",
                    "email" => "coder2k@test-conf.de",
                ],
            ],
        ]);
    }
}
