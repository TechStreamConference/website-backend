<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use App\Database\Seeds\MainSeeder;

class AdminDashboardTest extends CIUnitTestCase
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

    // *************************************
    // * setGlobals()
    // *************************************
    public function testSetGlobals_Returns204(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put(
                '/dashboard/admin/globals', [
                    'footer_text' => 'This is the new text.',
                ]
            );
        $response->assertStatus(204);

        $response = $this->get('/globals');
        $response->assertStatus(200);
        $response->assertJSONExact([
            'footer_text' => 'This is the new text.',
            'years_with_events' => [
                2024,
            ],
        ]);
    }

    // *************************************
    // * getAllEvents()
    // *************************************
    public function testGetAllEvents_Returns200(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->get('/dashboard/admin/all-events');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                'id' => 2,
                'title' => 'Tech Stream Conference 2025',
                'subtitle' => 'Das Imperium schlägt zurück!',
                'start_date' => '2025-06-22',
                'end_date' => '2025-06-23',
                'discord_url' => 'https://discord.com/invite/tp4EnphfKb',
                'twitch_url' => 'https://www.twitch.tv/coder2k',
                'presskit_url' => 'https://test-conf.de/Test-Conf-Presskit.zip',
                'trailer_youtube_id' => 'IW1vQAB6B18',
                'description_headline' => 'Komm\' ran!',
                'description' => "In einer weit, weit entfernten Galaxis...\nDie Tech Stream Conference 2025 steht unter dem Motto \"Das Imperium schlägt zurück!\".\nSei dabei, wenn wir die dunkle Seite der Macht beleuchten und uns mit den dunklen Machenschaften der Technik beschäftigen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen.\nAlso sei gespannt!",
                'schedule_visible_from' => '2025-06-22 12:00:00',
                'publish_date' => null,
                'call_for_papers_start' => null,
                'call_for_papers_end' => null,
            ],
            [
                'id' => 1,
                'title' => 'Tech Stream Conference 2024',
                'subtitle' => 'Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.',
                'start_date' => '2024-06-22',
                'end_date' => '2024-06-23',
                'discord_url' => 'https://discord.com/invite/tp4EnphfKb',
                'twitch_url' => 'https://www.twitch.tv/coder2k',
                'presskit_url' => 'https://test-conf.de/Test-Conf-Presskit.zip',
                'trailer_youtube_id' => 'IW1vQAB6B18',
                'description_headline' => 'Sei dabei!',
                'description' => "Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.\nWir möchten dich herzlich einladen, an unserer ersten Online-Konferenz teilzunehmen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen. Also sei gespannt!",
                'schedule_visible_from' => '2024-06-10 12:00:00',
                'publish_date' => '2024-01-01 12:00:00',
                'call_for_papers_start' => '2023-12-01 12:00:00',
                'call_for_papers_end' => '2030-03-01 12:00:00',
            ],
        ]);
    }

    // *************************************
    // * updateEvent()
    // *************************************
    public function testUpdateEvent_ValidData_Returns204(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put('/dashboard/admin/event/1', [
                'title' => 'New Event Title',
                'subtitle' => 'New Event Subtitle',
                'description' => 'New Event Description',
                'start_date' => '2025-11-05',
                'end_date' => '2025-11-06',
                'discord_url' => 'https://discord.gg/123456',
                'twitch_url' => 'https://twitch.tv/123456',
                'presskit_url' => 'https://presskit.com/123456',
                'trailer_youtube_id' => '123456',
                'description_headline' => 'New Event Description Headline',
                'schedule_visible_from' => '2025-11-05 12:00:00',
                'publish_date' => '2025-11-05 12:00:00',
                'call_for_papers_start' => '2025-11-05 12:00:00',
                'call_for_papers_end' => '2025-11-05 12:00:00',
            ]);
        $response->assertStatus(204);

        // additionally, we will check the updated values (to have a round-trip test)
        $response = $this
            ->withSession($sessionValues)
            ->get('/dashboard/admin/all-events');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                'id' => 1,
                'title' => 'New Event Title',
                'subtitle' => 'New Event Subtitle',
                'start_date' => '2025-11-05',
                'end_date' => '2025-11-06',
                'discord_url' => 'https://discord.gg/123456',
                'twitch_url' => 'https://twitch.tv/123456',
                'presskit_url' => 'https://presskit.com/123456',
                'trailer_youtube_id' => '123456',
                'description_headline' => 'New Event Description Headline',
                'description' => 'New Event Description',
                'schedule_visible_from' => '2025-11-05 12:00:00',
                'publish_date' => '2025-11-05 12:00:00',
                'call_for_papers_start' => '2025-11-05 12:00:00',
                'call_for_papers_end' => '2025-11-05 12:00:00',
            ],
            [
                'id' => 2,
                'title' => 'Tech Stream Conference 2025',
                'subtitle' => 'Das Imperium schlägt zurück!',
                'start_date' => '2025-06-22',
                'end_date' => '2025-06-23',
                'discord_url' => 'https://discord.com/invite/tp4EnphfKb',
                'twitch_url' => 'https://www.twitch.tv/coder2k',
                'presskit_url' => 'https://test-conf.de/Test-Conf-Presskit.zip',
                'trailer_youtube_id' => 'IW1vQAB6B18',
                'description_headline' => 'Komm\' ran!',
                'description' => "In einer weit, weit entfernten Galaxis...\nDie Tech Stream Conference 2025 steht unter dem Motto \"Das Imperium schlägt zurück!\".\nSei dabei, wenn wir die dunkle Seite der Macht beleuchten und uns mit den dunklen Machenschaften der Technik beschäftigen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen.\nAlso sei gespannt!",
                'schedule_visible_from' => '2025-06-22 12:00:00',
                'publish_date' => null,
                'call_for_papers_start' => null,
                'call_for_papers_end' => null,
            ]
        ]);
    }

    public function testUpdateEvent_ValidNullValues_Returns204(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put('/dashboard/admin/event/1', [
                'title' => 'New Event Title',
                'subtitle' => 'New Event Subtitle',
                'description' => 'New Event Description',
                'start_date' => '2025-11-05',
                'end_date' => '2025-11-06',
                'discord_url' => null,
                'twitch_url' => null,
                'presskit_url' => null,
                'trailer_youtube_id' => null,
                'description_headline' => 'New Event Description Headline',
                'schedule_visible_from' => null,
                'publish_date' => null,
                'call_for_papers_start' => null,
                'call_for_papers_end' => null,
            ]);
        $response->assertStatus(204);

        // additionally, we will check the updated values (to have a round-trip test)
        $response = $this
            ->withSession($sessionValues)
            ->get('/dashboard/admin/all-events');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                'id' => 1,
                'title' => 'New Event Title',
                'subtitle' => 'New Event Subtitle',
                'start_date' => '2025-11-05',
                'end_date' => '2025-11-06',
                'discord_url' => null,
                'twitch_url' => null,
                'presskit_url' => null,
                'trailer_youtube_id' => null,
                'description_headline' => 'New Event Description Headline',
                'description' => 'New Event Description',
                'schedule_visible_from' => null,
                'publish_date' => null,
                'call_for_papers_start' => null,
                'call_for_papers_end' => null,
            ],
            [
                'id' => 2,
                'title' => 'Tech Stream Conference 2025',
                'subtitle' => 'Das Imperium schlägt zurück!',
                'start_date' => '2025-06-22',
                'end_date' => '2025-06-23',
                'discord_url' => 'https://discord.com/invite/tp4EnphfKb',
                'twitch_url' => 'https://www.twitch.tv/coder2k',
                'presskit_url' => 'https://test-conf.de/Test-Conf-Presskit.zip',
                'trailer_youtube_id' => 'IW1vQAB6B18',
                'description_headline' => 'Komm\' ran!',
                'description' => "In einer weit, weit entfernten Galaxis...\nDie Tech Stream Conference 2025 steht unter dem Motto \"Das Imperium schlägt zurück!\".\nSei dabei, wenn wir die dunkle Seite der Macht beleuchten und uns mit den dunklen Machenschaften der Technik beschäftigen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen.\nAlso sei gespannt!",
                'schedule_visible_from' => '2025-06-22 12:00:00',
                'publish_date' => null,
                'call_for_papers_start' => null,
                'call_for_papers_end' => null,
            ],
        ]);
    }

    public function testUpdateEvent_RequiredValueIsNull_Returns400(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put('/dashboard/admin/event/1', [
                'title' => 'New Event Title',
                'subtitle' => 'New Event Subtitle',
                'description' => 'New Event Description',
                'start_date' => '2025-11-05',
                'end_date' => '2025-11-06',
                'discord_url' => null,
                'twitch_url' => null,
                'presskit_url' => null,
                'trailer_youtube_id' => null,
                'description_headline' => null, // must not be null
                'schedule_visible_from' => null,
                'publish_date' => null,
            ]);
        $response->assertStatus(400);
    }

    // *************************************
    // * createEvent()
    // *************************************
    public function testCreateEvent_ValidData_Returns201(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->post('/dashboard/admin/event/new', [
                'title' => 'New Event Title',
                'subtitle' => 'New Event Subtitle',
                'description' => 'New Event Description',
                'start_date' => '2025-11-05',
                'end_date' => '2025-11-06',
                'discord_url' => 'https://discord.gg/123456',
                'twitch_url' => 'https://twitch.tv/123456',
                'presskit_url' => 'https://presskit.com/123456',
                'trailer_youtube_id' => '123456',
                'description_headline' => 'New Event Description Headline',
                'schedule_visible_from' => '2025-11-05 12:00:00',
                'publish_date' => '2025-11-05 12:00:00',
                'call_for_papers_start' => '2025-11-05 12:00:00',
                'call_for_papers_end' => '2025-11-05 12:00:00',
            ]);
        $response->assertStatus(201);

        // additionally, we will check the created values (to have a round-trip test)
        $response = $this
            ->withSession($sessionValues)
            ->get('/dashboard/admin/all-events');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                'id' => 3,
                'title' => 'New Event Title',
                'subtitle' => 'New Event Subtitle',
                'start_date' => '2025-11-05',
                'end_date' => '2025-11-06',
                'discord_url' => 'https://discord.gg/123456',
                'twitch_url' => 'https://twitch.tv/123456',
                'presskit_url' => 'https://presskit.com/123456',
                'trailer_youtube_id' => '123456',
                'description_headline' => 'New Event Description Headline',
                'description' => 'New Event Description',
                'schedule_visible_from' => '2025-11-05 12:00:00',
                'publish_date' => '2025-11-05 12:00:00',
                'call_for_papers_start' => '2025-11-05 12:00:00',
                'call_for_papers_end' => '2025-11-05 12:00:00',
            ],
            [
                'id' => 2,
                'title' => 'Tech Stream Conference 2025',
                'subtitle' => 'Das Imperium schlägt zurück!',
                'start_date' => '2025-06-22',
                'end_date' => '2025-06-23',
                'discord_url' => 'https://discord.com/invite/tp4EnphfKb',
                'twitch_url' => 'https://www.twitch.tv/coder2k',
                'presskit_url' => 'https://test-conf.de/Test-Conf-Presskit.zip',
                'trailer_youtube_id' => 'IW1vQAB6B18',
                'description_headline' => 'Komm\' ran!',
                'description' => "In einer weit, weit entfernten Galaxis...\nDie Tech Stream Conference 2025 steht unter dem Motto \"Das Imperium schlägt zurück!\".\nSei dabei, wenn wir die dunkle Seite der Macht beleuchten und uns mit den dunklen Machenschaften der Technik beschäftigen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen.\nAlso sei gespannt!",
                'schedule_visible_from' => '2025-06-22 12:00:00',
                'publish_date' => null,
                'call_for_papers_start' => null,
                'call_for_papers_end' => null,
            ],
            [
                'id' => 1,
                'title' => 'Tech Stream Conference 2024',
                'subtitle' => 'Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.',
                'start_date' => '2024-06-22',
                'end_date' => '2024-06-23',
                'discord_url' => 'https://discord.com/invite/tp4EnphfKb',
                'twitch_url' => 'https://www.twitch.tv/coder2k',
                'presskit_url' => 'https://test-conf.de/Test-Conf-Presskit.zip',
                'trailer_youtube_id' => 'IW1vQAB6B18',
                'description_headline' => 'Sei dabei!',
                'description' => "Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.\nWir möchten dich herzlich einladen, an unserer ersten Online-Konferenz teilzunehmen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen. Also sei gespannt!",
                'schedule_visible_from' => '2024-06-10 12:00:00',
                'publish_date' => '2024-01-01 12:00:00',
                'call_for_papers_start' => '2023-12-01 12:00:00',
                'call_for_papers_end' => '2030-03-01 12:00:00',
            ],
        ]);
    }

    public function testCreateEvent_ValidNullValues_Returns201(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->post('/dashboard/admin/event/new', [
                'title' => 'New Event Title',
                'subtitle' => 'New Event Subtitle',
                'description' => 'New Event Description',
                'start_date' => '2025-11-05',
                'end_date' => '2025-11-06',
                'discord_url' => null,
                'twitch_url' => null,
                'presskit_url' => null,
                'trailer_youtube_id' => null,
                'description_headline' => 'New Event Description Headline',
                'schedule_visible_from' => null,
                'publish_date' => null,
                'call_for_papers_start' => null,
                'call_for_papers_end' => null,
            ]);
        $response->assertStatus(201);

        // additionally, we will check the created values (to have a round-trip test)
        $response = $this
            ->withSession($sessionValues)
            ->get('/dashboard/admin/all-events');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                'id' => 3,
                'title' => 'New Event Title',
                'subtitle' => 'New Event Subtitle',
                'start_date' => '2025-11-05',
                'end_date' => '2025-11-06',
                'discord_url' => null,
                'twitch_url' => null,
                'presskit_url' => null,
                'trailer_youtube_id' => null,
                'description_headline' => 'New Event Description Headline',
                'description' => 'New Event Description',
                'schedule_visible_from' => null,
                'publish_date' => null,
                'call_for_papers_start' => null,
                'call_for_papers_end' => null,
            ],
            [
                'id' => 2,
                'title' => 'Tech Stream Conference 2025',
                'subtitle' => 'Das Imperium schlägt zurück!',
                'start_date' => '2025-06-22',
                'end_date' => '2025-06-23',
                'discord_url' => 'https://discord.com/invite/tp4EnphfKb',
                'twitch_url' => 'https://www.twitch.tv/coder2k',
                'presskit_url' => 'https://test-conf.de/Test-Conf-Presskit.zip',
                'trailer_youtube_id' => 'IW1vQAB6B18',
                'description_headline' => 'Komm\' ran!',
                'description' => "In einer weit, weit entfernten Galaxis...\nDie Tech Stream Conference 2025 steht unter dem Motto \"Das Imperium schlägt zurück!\".\nSei dabei, wenn wir die dunkle Seite der Macht beleuchten und uns mit den dunklen Machenschaften der Technik beschäftigen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch \"special guests\" und Überraschungen.\nAlso sei gespannt!",
                'schedule_visible_from' => "2025-06-22 12:00:00",
                'publish_date' => null,
                'call_for_papers_start' => null,
                'call_for_papers_end' => null,
            ],
            [
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
        ]);
    }

    public function testCreateEvent_RequiredValueIsNull_Returns400(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->post('/dashboard/admin/event/new', [
                "title" => "New Event Title",
                "subtitle" => "New Event Subtitle",
                "description" => "New Event Description",
                "start_date" => "2025-11-05",
                "end_date" => "2025-11-06",
                "discord_url" => null,
                "twitch_url" => null,
                "presskit_url" => null,
                "trailer_youtube_id" => null,
                "description_headline" => null, // must not be null
                "schedule_visible_from" => null,
                "publish_date" => null,
            ]);
        $response->assertStatus(400);
    }

    // *************************************
    // * updateSpeakerDates()
    // *************************************
    public function testUpdateSpeakerDates_ValidData_Returns204(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put('/dashboard/admin/event/1/speaker', [
                [
                    'id' => 2, // coder2k
                    'visible_from' => '2025-11-05 15:00:00',
                ],
                [
                    'id' => 4, // GyrosGeier
                    'visible_from' => '2025-11-06 15:00:00',
                ],
                [
                    'id' => 5, // codingPurpurTentakel
                    'visible_from' => '2025-11-07 15:00:00',
                ]
            ]);
        $response->assertStatus(204);

        // additionally, we will check the updated values (to have a round-trip test)
        $response = $this
            ->withSession($sessionValues)
            ->get('/dashboard/admin/event/1/speaker');
        $response->assertStatus(200);
        $response->assertJSONExact([
            [
                "bio" => "Michael (coder2k) hat vor über 20 Jahren 'Turbo Pascal und Delphi für Kids' gelesen und sich seitdem mit dem Programmieren in verschiedenen Programmiersprachen beschäftigt. Er ist tätig als Software-Entwickler im Embedded-Umfeld und freier Dozent. Seit drei Jahren programmiert er auch auf Twitch und ist seit Anfang 2024 Twitch-Partner. Michael ist es wichtig, Wissen mit anderen auszutauschen und sich dadurch gemeinsam weiterzuentwickeln und neue Dinge zu lernen – und daraus ist auch die Idee zur Test-Conf entstanden.",
                "id" => 2,
                "name" => "coder2k",
                "photo" => "coder2k.jpg",
                "short_bio" => "Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner",
                "user_id" => 1,
                "visible_from" => "2025-11-05 15:00:00"
            ],
            [
                "bio" => "GyrosGeier hat nicht nur einen witzigen Namen – nein – er kennt sich auch ziemlich gut im Bereich der Low-Level- bzw. Systemprogrammierung aus. Im vergangenen Jahr ist er nach Tokyo ausgewandert und arbeitet dort für eine Firma, die Mikrosatelliten ins Weltall schießt. In seinen Streams bastelt er an zahlreichen Projekten und vergisst niemals, den Yak-Stapel zu vergrößern.",
                "id" => 4,
                "name" => "GyrosGeier",
                "photo" => "GyrosGeier.jpg",
                "short_bio" => "Embedded- und Lowlevel-Coding",
                "user_id" => 2,
                "visible_from" => "2025-11-06 15:00:00"
            ],
            [
                "bio" => "Martin (Purpur Tentakel) kommt aus Köln. Nach der Schule macht er eine Ausbildung zur Fachkraft für Veranstaltungstechnik. Durch Corona kann er nach der Ausbildung nicht in der Branche weiter arbeiten und macht eine 2. Ausbildung zum Elektroniker für Betriebstechnik. In der Zeit der 2. Ausblidung trifft er irgendwann mal auf den Kanal von coder2k. Tja nun muss er coden. Von Python über C# kommt er schließlich zu c++. Seither programmiert er an seinem Spiel 'Tentakels Attacking'",
                "id" => 5,
                "name" => "codingPurpurTentakel",
                "photo" => "codingPurpurTentakel.jpg",
                "short_bio" => "Test-Conf Host, Veranstaltungstechniker, Elektroniker, Hobby-Coder",
                "user_id" => 4,
                "visible_from" => "2025-11-07 15:00:00"
            ]
        ]);
    }

    public function testUpdateSpeakerDates_invalidEventId_Returns404(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put('/dashboard/admin/event/999/speaker', [
                [
                    'id' => 2, // coder2k
                    'visible_from' => '2025-11-05 15:00:00',
                ],
                [
                    'id' => 4, // GyrosGeier
                    'visible_from' => '2025-11-06 15:00:00',
                ],
                [
                    'id' => 5, // codingPurpurTentakel
                    'visible_from' => '2025-11-07 15:00:00',
                ]
            ]);
        $response->assertStatus(404);
    }

    public function testUpdateSpeakerDates_invalidSpeakerId_Returns404(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put('/dashboard/admin/event/1/speaker', [
                [
                    'id' => 2, // coder2k
                    'visible_from' => '2025-11-05 15:00:00',
                ],
                [
                    'id' => 999, // invalid speaker id
                    'visible_from' => '2025-11-06 15:00:00',
                ],
                [
                    'id' => 5, // codingPurpurTentakel
                    'visible_from' => '2025-11-07 15:00:00',
                ]
            ]);
        $response->assertStatus(404);
    }

    public function testUpdateSpeakerDates_invalidDate_Returns400(): void
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put('/dashboard/admin/event/1/speaker', [
                [
                    'id' => 2, // coder2k
                    'visible_from' => '2025-11-05 15:00:00',
                ],
                [
                    'id' => 4, // GyrosGeier
                    'visible_from' => '2025-11-06 15:00:00',
                ],
                [
                    'id' => 5, // codingPurpurTentakel
                    'visible_from' => 'invalid date',
                ]
            ]);
        $response->assertStatus(400);
    }
}
