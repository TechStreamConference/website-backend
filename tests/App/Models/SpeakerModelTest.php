<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
 use App\Database\Seeds\MainSeeder;

class SpeakerModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh = true;
    protected $namespace = null; // run all migrations from all available namespaces (like php spark migrate --all)

    protected $seed = MainSeeder::class;
    protected $seedOnce = false;
    protected $basePath = 'app/Database';

    // *************************************
    // * get()
    // *************************************
    public function testGet_ValidId_ReturnsArray(): void
    {
        $model = new SpeakerModel();
        $speaker = $model->get(1);
        $this->assertNotNull($speaker);
        $this->assertEquals('coder3k', $speaker['name']);
        $this->assertEquals('Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner', $speaker['short_bio']);
        $this->assertEquals(
            'Michael (coder2k) hat vor über 20 Jahren \'Turbo Pascal und Delphi für Kids\' gelesen und sich seitdem mit dem Programmieren in verschiedenen Programmiersprachen beschäftigt. Er ist tätig als Software-Entwickler im Embedded-Umfeld und freier Dozent. Seit drei Jahren programmiert er auch auf Twitch und ist seit Anfang 2024 Twitch-Partner. Michael ist es wichtig, Wissen mit anderen auszutauschen und sich dadurch gemeinsam weiterzuentwickeln und neue Dinge zu lernen – und daraus ist auch die Idee zur Test-Conf entstanden.',
            $speaker['bio'],
        );
        $this->assertEquals('coder2k.jpg', $speaker['photo']);
        $this->assertEquals('image/jpeg', $speaker['photo_mime_type']);
        $this->assertTrue((bool)$speaker['is_approved']);
        $this->assertEquals(date('2024-06-01 15:00:00'), $speaker['visible_from']);
    }

    public function testGet_InvalidId_ReturnsNull(): void
    {
        $model = new SpeakerModel();
        $speaker = $model->get(10);
        $this->assertNull($speaker);
    }

    // *************************************
    // * getPublished()
    // *************************************
    public function testGetPublished_ReturnsArray(): void
    {
        $model = new SpeakerModel();
        $speakers = $model->getPublished(1);
        $this->assertIsArray($speakers);
        $this->assertCount(3, $speakers);
        $this->assertEquals('coder2k', $speakers[0]['name']);
        $this->assertEquals('codingPurpurTentakel', $speakers[1]['name']);
        $this->assertEquals('Test-Conf Host, Veranstaltungstechniker, Elektroniker, Hobby-Coder', $speakers[1]['short_bio']);
        $this->assertEquals(
            'Martin (Purpur Tentakel) kommt aus Köln. Nach der Schule macht er eine Ausbildung zur Fachkraft für Veranstaltungstechnik. Durch Corona kann er nach der Ausbildung nicht in der Branche weiter arbeiten und macht eine 2. Ausbildung zum Elektroniker für Betriebstechnik. In der Zeit der 2. Ausblidung trifft er irgendwann mal auf den Kanal von coder2k. Tja nun muss er coden. Von Python über C# kommt er schließlich zu c++. Seither programmiert er an seinem Spiel \'Tentakels Attacking\'',
            $speakers[1]['bio'],
        );
        $this->assertEquals('codingPurpurTentakel.jpg', $speakers[1]['photo']);
        $this->assertEquals('GyrosGeier', $speakers[2]['name']);
    }

    // *************************************
    // * create()
    // *************************************
    public function testCreate_ReturnsId(): void
    {
        $model = new SpeakerModel();
        $this->assertEquals(
            8,
            $model->create(
                'Test Speaker',
                4,
                1,
                'Test Short Bio',
                'Test Bio',
                'images/test.jpg',
                'image/jpeg',
                true,
                date('Y-m-d H:i:s'),
            )
        );
    }
}
