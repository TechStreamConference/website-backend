<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use App\Database\Seeds\MainSeeder;

class GlobalsTest extends CIUnitTestCase
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

    public function testGet_returnsGlobals(): void
    {
        $response = $this->get('/globals');
        $response->assertStatus(200);
        $response->assertJSONExact([
            'footer_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ac ante mollis, fermentum nunc nec, tincidunt nunc. Sed nec nunc nec nunc.',
            'years_with_events' => [
                2024,
            ],
        ]);
    }
}
