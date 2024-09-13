<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class SpeakerModelTest extends CIUnitTestCase
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
    // * get()
    // *************************************
    public function testGet_ValidId_ReturnsArray()
    {
        $model = new SpeakerModel();
        $speaker = $model->get(1);
        $this->assertNotNull($speaker);
        $this->assertEquals('coder2k', $speaker['name']);
        $this->assertEquals('Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner', $speaker['short_bio']);
        $this->assertEquals(
            'Michael (coder2k) hat vor über 20 Jahren \'Turbo Pascal und Delphi für Kids\' gelesen und sich seitdem mit dem Programmieren in verschiedenen Programmiersprachen beschäftigt. Er ist tätig als Software-Entwickler im Embedded-Umfeld und freier Dozent. Seit drei Jahren programmiert er auch auf Twitch und ist seit Anfang 2024 Twitch-Partner. Michael ist es wichtig, Wissen mit anderen auszutauschen und sich dadurch gemeinsam weiterzuentwickeln und neue Dinge zu lernen – und daraus ist auch die Idee zur Test-Conf entstanden.',
            $speaker['bio'],
        );
        $this->assertEquals('image/jpeg', $speaker['photo_mime_type']);
        $this->assertTrue(boolval($speaker['is_active']));
        $this->assertEquals(date('2024-06-01 15:00:00'), $speaker['visible_from']);
    }

    public function testGet_InvalidId_ReturnsNull()
    {
        $model = new SpeakerModel();
        $speaker = $model->get(7);
        $this->assertNull($speaker);
    }

    // *************************************
    // * getPublished()
    // *************************************
    public function testGetPublished_ReturnsArray()
    {
        $model = new SpeakerModel();
        $speakers = $model->getPublished();
        $this->assertIsArray($speakers);
        $this->assertCount(1, $speakers);
        $this->assertEquals(1, $speakers[0]['id']);
        $this->assertEquals('coder2k', $speakers[0]['name']);
        $this->assertEquals('Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner', $speakers[0]['short_bio']);
        $this->assertEquals(
            'Michael (coder2k) hat vor über 20 Jahren \'Turbo Pascal und Delphi für Kids\' gelesen und sich seitdem mit dem Programmieren in verschiedenen Programmiersprachen beschäftigt. Er ist tätig als Software-Entwickler im Embedded-Umfeld und freier Dozent. Seit drei Jahren programmiert er auch auf Twitch und ist seit Anfang 2024 Twitch-Partner. Michael ist es wichtig, Wissen mit anderen auszutauschen und sich dadurch gemeinsam weiterzuentwickeln und neue Dinge zu lernen – und daraus ist auch die Idee zur Test-Conf entstanden.',
            $speakers[0]['bio'],
        );
        $this->assertEquals('image/jpeg', $speakers[0]['photo_mime_type']);
    }

    // *************************************
    // * create()
    // *************************************
    public function testCreate_ReturnsTrue()
    {
        $model = new SpeakerModel();
        $this->assertEquals(
            4,
            $model->create(
                'Test Speaker',
                'Test Short Bio',
                'Test Bio',
                'Test Photo',
                'image/jpeg',
                true,
                date('Y-m-d H:i:s'),
            ));
    }
}
