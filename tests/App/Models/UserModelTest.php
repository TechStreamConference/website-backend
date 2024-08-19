<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class UserModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh = true;
    protected $namespace = null; // run all migrations from all available namespaces (like php spark migrate --all)

    protected $seed = 'App\Database\Seeds\MainSeeder';
    protected $seedOnce = false;
    protected $basePath = 'app/Database';

    public function testGetUser()
    {
        $model = new UserModel();
        $this->assertIsArray($model->getUser());

        $user = $model->getUser(1);
        $this->assertNotNull($user);
        $this->assertEquals(1, $user['id']);
        $this->assertEquals('1985-10-21 07:28:00', $user['created_at']);
        $this->assertEquals('1985-10-21 07:28:00', $user['updated_at']);
        $this->assertNull($user['deleted_at']);

        $user = $model->getUser(2);
        $this->assertNotNull($user);
        $this->assertEquals(2, $user['id']);
        $this->assertEquals('2024-08-17 13:39:35', $user['created_at']);
        $this->assertEquals('2024-08-17 13:39:35', $user['updated_at']);
        $this->assertNull($user['deleted_at']);

        $user = $model->getUser(3);
        $this->assertNull($user);
    }

    public function testCreateUser()
    {
        $model = new UserModel();
        $userId = $model->createUser();
        $this->assertEquals(3, $userId);

        $user = $model->getUser(3);
        $this->assertNotNull($user);
        $this->assertEquals(3, $user['id']);
        $this->assertNotNull($user['created_at']);
        $this->assertNotNull($user['updated_at']);
        $this->assertNull($user['deleted_at']);
    }
}
