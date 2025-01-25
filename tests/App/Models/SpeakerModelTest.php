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
        $this->assertEquals('coder3k', $speaker['name']);
        $this->assertEquals('Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner', $speaker['short_bio']);
        $this->assertEquals(
            'Michael (coder2k) hat vor über 20 Jahren \'Turbo Pascal und Delphi für Kids\' gelesen und sich seitdem mit dem Programmieren in verschiedenen Programmiersprachen beschäftigt. Er ist tätig als Software-Entwickler im Embedded-Umfeld und freier Dozent. Seit drei Jahren programmiert er auch auf Twitch und ist seit Anfang 2024 Twitch-Partner. Michael ist es wichtig, Wissen mit anderen auszutauschen und sich dadurch gemeinsam weiterzuentwickeln und neue Dinge zu lernen – und daraus ist auch die Idee zur Test-Conf entstanden.',
            $speaker['bio'],
        );
        $this->assertEquals('images/coder2k.jpg', $speaker['photo']);
        $this->assertEquals('image/jpeg', $speaker['photo_mime_type']);
        $this->assertTrue((bool)$speaker['is_approved']);
        $this->assertEquals(date('2024-06-01 15:00:00'), $speaker['visible_from']);
    }

    public function testGet_InvalidId_ReturnsNull()
    {
        $model = new SpeakerModel();
        $speaker = $model->get(10);
        $this->assertNull($speaker);
    }

    // *************************************
    // * getPublished()
    // *************************************
    public function testGetPublished_ReturnsArray()
    {
        $model = new SpeakerModel();
        $speakers = $model->getPublished(1);
        $this->assertIsArray($speakers);
        $this->assertCount(3, $speakers);
        $this->assertEquals('coder2k', $speakers[0]['name']);
        $this->assertEquals('Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner', $speakers[0]['short_bio']);
        $this->assertEquals(
            'Michael (coder2k) hat vor über 20 Jahren \'Turbo Pascal und Delphi für Kids\' gelesen und sich seitdem mit dem Programmieren in verschiedenen Programmiersprachen beschäftigt. Er ist tätig als Software-Entwickler im Embedded-Umfeld und freier Dozent. Seit drei Jahren programmiert er auch auf Twitch und ist seit Anfang 2024 Twitch-Partner. Michael ist es wichtig, Wissen mit anderen auszutauschen und sich dadurch gemeinsam weiterzuentwickeln und neue Dinge zu lernen – und daraus ist auch die Idee zur Test-Conf entstanden.',
            $speakers[0]['bio'],
        );
        $this->assertEquals('images/coder2k.jpg', $speakers[0]['photo']);
        $this->assertEquals('codingPurpurTentakel', $speakers[1]['name']);
    }

    // *************************************
    // * create()
    // *************************************
    public function testCreate_ReturnsId()
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
