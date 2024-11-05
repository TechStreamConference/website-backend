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

    public function testSetGlobals_returns204()
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
}
