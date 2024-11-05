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
        $eventId = $model->create(
            'Test Event',
            'Test Event Subtitle',
            '2024-06-22',
            '2024-06-23',
            'https://discord.com/invite/tp4EnphfKb',
            'https://www.twitch.tv/coder2k',
            'https://test-conf.de/Test-Conf-Presskit.zip',
            'https://youtu.be/IW1vQAB6B18',
            'Test Event Headline',
            'Test Event Description'
        );
        $this->assertEquals(3, $eventId);
    }
}
