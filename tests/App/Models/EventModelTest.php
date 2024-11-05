<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class EventModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh = true;
    protected $namespace = null; // run all migrations from all available namespaces (like php spark migrate --all)

    protected $seed = 'App\Database\Seeds\MainSeeder';
    protected $seedOnce = false;
    protected $basePath = 'app/Database';

    // *************************************
    // * getPublished()
    // *************************************
    public function testGetPublished_ValidId_ReturnsArray()
    {
        $model = new EventModel();
        $event = $model->getPublished(1);
        $this->assertNotNull($event);
        $this->assertEquals(1, $event['id']);
        $this->assertEquals('Tech Stream Conference 2024', $event['title']);
        $this->assertEquals('Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.', $event['subtitle']);
        $this->assertEquals('2024-06-22', $event['start_date']);
        $this->assertEquals('2024-06-23', $event['end_date']);
        $this->assertEquals('https://discord.com/invite/tp4EnphfKb', $event['discord_url']);
        $this->assertEquals('https://www.twitch.tv/coder2k', $event['twitch_url']);
        $this->assertEquals('https://test-conf.de/Test-Conf-Presskit.zip', $event['presskit_url']);
        $this->assertEquals('IW1vQAB6B18', $event['trailer_youtube_id']);
        $this->assertEquals('Sei dabei!', $event['description_headline']);
        $this->assertEquals(
            'Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.
Wir möchten dich herzlich einladen, an unserer ersten Online-Konferenz teilzunehmen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch "special guests" und Überraschungen. Also sei gespannt!',
            $event['description']
        );
    }

    public function testGetPublished_InvalidId_ReturnsNull()
    {
        $model = new EventModel();
        $event = $model->getPublished(4);
        $this->assertNull($event);
    }

    // *************************************
    // * getPublishedByYear()
    // *************************************
    public function testGetPublishedByYear_ValidYear_ReturnsArray()
    {
        $model = new EventModel();
        $event = $model->getPublishedByYear(2024);
        $this->assertNotNull($event);
        $this->assertEquals(1, $event['id']);
        $this->assertEquals('Tech Stream Conference 2024', $event['title']);
        $this->assertEquals('Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.', $event['subtitle']);
        $this->assertEquals('2024-06-22', $event['start_date']);
        $this->assertEquals('2024-06-23', $event['end_date']);
        $this->assertEquals('https://discord.com/invite/tp4EnphfKb', $event['discord_url']);
        $this->assertEquals('https://www.twitch.tv/coder2k', $event['twitch_url']);
        $this->assertEquals('https://test-conf.de/Test-Conf-Presskit.zip', $event['presskit_url']);
        $this->assertEquals('IW1vQAB6B18', $event['trailer_youtube_id']);
        $this->assertEquals('Sei dabei!', $event['description_headline']);
        $this->assertEquals(
            'Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.
Wir möchten dich herzlich einladen, an unserer ersten Online-Konferenz teilzunehmen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch "special guests" und Überraschungen. Also sei gespannt!',
            $event['description']
        );
    }

    public function testGetPublishedByYear_InvalidYear_ReturnsNull()
    {
        $model = new EventModel();
        $event = $model->getPublishedByYear(2028);
        $this->assertNull($event);
    }

    // *************************************
    // * create()
    // *************************************
    public function testCreate_ReturnsId()
    {
        $model = new EventModel();
        $eventId = $model->createEvent(
            'Test Event',
            'Test Event Subtitle',
            '2024-06-22',
            '2024-06-23',
            'https://discord.com/invite/tp4EnphfKb',
            'https://www.twitch.tv/coder2k',
            'https://test-conf.de/Test-Conf-Presskit.zip',
            'IW1vQAB6B18',
            'Test Event Description Headline',
            'Test Event Description',
            '2024-01-01 12:00:00',
            '2024-01-01 12:00:00'
        );
        $this->assertEquals(3, $eventId);
    }

    // *************************************
    // * getAll()
    // *************************************
    public function testGetAll_ReturnsArray()
    {
        $model = new EventModel();
        $events = $model->getAll();
        $this->assertCount(2, $events);

        // newest event first
        $this->assertEquals(2, $events[0]['id']);
        $this->assertEquals('Tech Stream Conference 2025', $events[0]['title']);
        $this->assertEquals('Das Imperium schlägt zurück!', $events[0]['subtitle']);
        $this->assertEquals('2025-06-22', $events[0]['start_date']);
        $this->assertEquals('2025-06-23', $events[0]['end_date']);
        $this->assertEquals('https://discord.com/invite/tp4EnphfKb', $events[0]['discord_url']);
        $this->assertEquals('https://www.twitch.tv/coder2k', $events[0]['twitch_url']);
        $this->assertEquals('https://test-conf.de/Test-Conf-Presskit.zip', $events[0]['presskit_url']);
        $this->assertEquals('IW1vQAB6B18', $events[0]['trailer_youtube_id']);
        $this->assertEquals('Komm\' ran!', $events[0]['description_headline']);
        $this->assertEquals(
            'In einer weit, weit entfernten Galaxis...
Die Tech Stream Conference 2025 steht unter dem Motto "Das Imperium schlägt zurück!".
Sei dabei, wenn wir die dunkle Seite der Macht beleuchten und uns mit den dunklen Machenschaften der Technik beschäftigen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch "special guests" und Überraschungen.
Also sei gespannt!',
            $events[0]['description']
        );
        $this->assertNull($events[0]['publish_date']);

        $this->assertEquals(1, $events[1]['id']);
        $this->assertEquals('Tech Stream Conference 2024', $events[1]['title']);
        $this->assertEquals('Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.', $events[1]['subtitle']);
        $this->assertEquals('2024-06-22', $events[1]['start_date']);
        $this->assertEquals('2024-06-23', $events[1]['end_date']);
        $this->assertEquals('https://discord.com/invite/tp4EnphfKb', $events[1]['discord_url']);
        $this->assertEquals('https://www.twitch.tv/coder2k', $events[1]['twitch_url']);
        $this->assertEquals('https://test-conf.de/Test-Conf-Presskit.zip', $events[1]['presskit_url']);
        $this->assertEquals('IW1vQAB6B18', $events[1]['trailer_youtube_id']);
        $this->assertEquals('Sei dabei!', $events[1]['description_headline']);
        $this->assertEquals('2024-01-01 12:00:00', $events[1]['publish_date']);
    }

    // *************************************
    // * updateEvent()
    // *************************************
    public function testUpdateEvent() {
        $model = new EventModel();
        $model->updateEvent(
            1,
            'Updated Event',
            'Updated Event Subtitle',
            '2024-06-23',
            '2024-06-24',
            'https://discord.com/invite/tp4EnphfKb',
            'https://www.twitch.tv/coder2k',
            'https://test-conf.de/Test-Conf-Presskit.zip',
            'IW1vQAB6B18',
            'Updated Event Headline',
            'Updated Event Description',
            '2024-01-01 12:00:00',
            '2024-01-01 12:00:00'
        );
        $events = $model->getAll();
        $this->assertCount(2, $events);
        $this->assertEquals('Updated Event', $events[1]['title']);
        $this->assertEquals('Updated Event Subtitle', $events[1]['subtitle']);
        $this->assertEquals('2024-06-23', $events[1]['start_date']);
        $this->assertEquals('2024-06-24', $events[1]['end_date']);
        $this->assertEquals('https://discord.com/invite/tp4EnphfKb', $events[1]['discord_url']);
        $this->assertEquals('https://www.twitch.tv/coder2k', $events[1]['twitch_url']);
        $this->assertEquals('https://test-conf.de/Test-Conf-Presskit.zip', $events[1]['presskit_url']);
        $this->assertEquals('IW1vQAB6B18', $events[1]['trailer_youtube_id']);
        $this->assertEquals('Updated Event Headline', $events[1]['description_headline']);
        $this->assertEquals('Updated Event Description', $events[1]['description']);
        $this->assertEquals('2024-01-01 12:00:00', $events[1]['publish_date']);
    }

    // *************************************
    // * createEvent()
    // *************************************
    public function testCreateEvent() {
        $model = new EventModel();
        $eventId = $model->createEvent(
            'Test Event',
            'Test Event Subtitle',
            '2026-06-22',
            '2026-06-23',
            'https://discord.com/invite/tp4EnphfKb',
            'https://www.twitch.tv/coder2k',
            'https://test-conf.de/Test-Conf-Presskit.zip',
            'IW1vQAB6B18',
            'Test Event Headline',
            'Test Event Description',
            '2026-01-01 12:00:00',
            '2026-01-01 12:00:00'
        );
        $events = $model->getAll();
        $this->assertCount(3, $events);
        $this->assertEquals('Test Event', $events[0]['title']);
        $this->assertEquals('Test Event Subtitle', $events[0]['subtitle']);
        $this->assertEquals('2026-06-22', $events[0]['start_date']);
        $this->assertEquals('2026-06-23', $events[0]['end_date']);
        $this->assertEquals('https://discord.com/invite/tp4EnphfKb', $events[0]['discord_url']);
        $this->assertEquals('https://www.twitch.tv/coder2k', $events[0]['twitch_url']);
        $this->assertEquals('https://test-conf.de/Test-Conf-Presskit.zip', $events[0]['presskit_url']);
        $this->assertEquals('IW1vQAB6B18', $events[0]['trailer_youtube_id']);
        $this->assertEquals('Test Event Headline', $events[0]['description_headline']);
        $this->assertEquals('Test Event Description', $events[0]['description']);
        $this->assertEquals('2026-01-01 12:00:00', $events[0]['publish_date']);
    }
}
