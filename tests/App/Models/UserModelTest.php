<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Database\Seeds\MainSeeder;

class UserModelTest extends CIUnitTestCase
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
    // * getUser()
    // *************************************
    public function testGetUser_ValidId_ReturnsArray(): void
    {
        $model = new UserModel();
        $user = $model->getUser(1);
        $this->assertNotNull($user);
        $this->assertEquals(1, $user['id']);
        $this->assertEquals('1985-10-21 07:28:00', $user['created_at']);
        $this->assertEquals('1985-10-21 07:28:00', $user['updated_at']);
        $this->assertNull($user['deleted_at']);
    }


    public function testGetUser_InvalidId_ReturnsNull(): void
    {
        $model = new UserModel();
        $this->assertIsArray($model->getUser());
        $user = $model->getUser(6);
        $this->assertNull($user);
    }

    // *************************************
    // * createUser()
    // *************************************
    public function testCreateUser_ReturnsId(): void
    {
        $model = new UserModel();
        $userId = $model->createUser();
        $this->assertEquals(6, $userId);
    }

    // *************************************
    // * deleteUser()
    // *************************************
    public function testDeleteUser_UserExists_ReturnsTrue(): void
    {
        $model = new UserModel();
        $this->assertTrue($model->deleteUser(3)); // can only delete a user not referenced in other tables
    }

    public function testDeleteUser_UserDoesNotExist_ReturnsTrue(): void
    {
        $model = new UserModel();
        $this->assertTrue($model->deleteUser(40)); // deleting a non-existing user is not an error
    }

    // *************************************
    // * getRoles()
    // *************************************
    public function testGetRoles_UserHasAccount_ReturnsArray(): void
    {
        $model = new UserModel();
        $roles = $model->getRoles(1);
        $this->assertNotNull($roles);
        $this->assertTrue($roles['has_account']);
    }

    public function testGetRoles_UserDoesNotHaveAccount_ReturnsArray(): void
    {
        $model = new UserModel();
        $roles = $model->getRoles(3);
        $this->assertNotNull($roles);
        $this->assertFalse($roles['has_account']);
    }

    public function testGetRoles_UserDoesNotExist_ReturnsNull(): void
    {
        $model = new UserModel();
        $roles = $model->getRoles(6);
        $this->assertNull($roles);
    }
}
