<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class AdminDashboardTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh = true;
    protected $namespace = null; // run all migrations from all available namespaces (like php spark migrate --all)

    protected $seed = 'App\Database\Seeds\MainSeeder';
    protected $seedOnce = false;
    protected $basePath = 'app/Database';

    public function testSetGlobals_Returns204()
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
        $response->assertJSON([
            'footer_text' => 'This is the new text.',
        ]);
    }

    public function testGetAllEvents_Returns200()
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->get('/dashboard/admin/all-events');
        $response->assertStatus(200);
        $response->assertJSON([
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
                'publish_date' => null,
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
                'publish_date' => '2024-01-01 12:00:00',
            ],
        ]);
    }

    public function testGetEvent_PublishedEvent_Returns200()
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->get('/dashboard/admin/event/1');
        $response->assertStatus(200);
        $response->assertJSON(
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
                'publish_date' => '2024-01-01 12:00:00',
            ]
        );
    }

    public function testGetEvent_UnpublishedEvent_Returns200()
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->get('/dashboard/admin/event/2');
        $response->assertStatus(200);
        $response->assertJSON(
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
                'publish_date' => null,
            ]
        );
    }

    public function testGetEvent_InvalidEventId_Returns404()
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->get('/dashboard/admin/event/3');
        $response->assertStatus(404);
    }

    public function testUpdateEvent_ValidData_Returns204()
    {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put('/dashboard/admin/event/1', [
                "title" => "New Event Title",
                "subtitle" => "New Event Subtitle",
                "description" => "New Event Description",
                "start_date" => "2025-11-05",
                "end_date" => "2025-11-06",
                "discord_url" => "https://discord.gg/123456",
                "twitch_url" => "https://twitch.tv/123456",
                "presskit_url" => "https://presskit.com/123456",
                "trailer_youtube_id" => "123456",
                "description_headline" => "New Event Description Headline",
                "schedule_visible_from" => "2025-11-05 12:00:00",
                "publish_date" => "2025-11-05 12:00:00",
            ]);
        $response->assertStatus(204);
    }

    public function testUpdateEvent_ValidNullValues_Returns204() {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put('/dashboard/admin/event/1', [
                "title" => "New Event Title",
                "subtitle" => "New Event Subtitle",
                "description" => "New Event Description",
                "start_date" => "2025-11-05",
                "end_date" => "2025-11-06",
                "discord_url" => null,
                "twitch_url" => null,
                "presskit_url" => null,
                "trailer_youtube_id" => null,
                "description_headline" => "New Event Description Headline",
                "schedule_visible_from" => null,
                "publish_date" => null,
            ]);
        $response->assertStatus(204);
    }

    public function testUpdateEvent_RequiredValueIsNull_Returns400() {
        $sessionValues = [
            "user_id" => 1,
        ];
        $response = $this
            ->withSession($sessionValues)
            ->withBodyFormat('json')
            ->put('/dashboard/admin/event/1', [
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

    public function testCreateEvent_ValidData_Returns201()
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
                "discord_url" => "https://discord.gg/123456",
                "twitch_url" => "https://twitch.tv/123456",
                "presskit_url" => "https://presskit.com/123456",
                "trailer_youtube_id" => "123456",
                "description_headline" => "New Event Description Headline",
                "schedule_visible_from" => "2025-11-05 12:00:00",
                "publish_date" => "2025-11-05 12:00:00",
            ]);
        $response->assertStatus(201);
    }

    public function testCreateEvent_ValidNullValues_Returns201()
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
                "description_headline" => "New Event Description Headline",
                "schedule_visible_from" => null,
                "publish_date" => null,
            ]);
        $response->assertStatus(201);
    }

    public function testCreateEvent_RequiredValueIsNull_Returns400()
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
}
