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
        $this->assertNotNull($user['created_at']);
        $this->assertNotNull($user['updated_at']);
        $this->assertNull($user['deleted_at']);

        $user = $model->getUser(2);
        $this->assertNull($user);
    }

    public function testCreateUser()
    {
        $model = new UserModel();
        $userId = $model->createUser();
        $this->assertEquals(2, $userId);

        $user = $model->getUser(2);
        $this->assertNotNull($user);
        $this->assertEquals(2, $user['id']);
        $this->assertNotNull($user['created_at']);
        $this->assertNotNull($user['updated_at']);
        $this->assertNull($user['deleted_at']);
    }
}
