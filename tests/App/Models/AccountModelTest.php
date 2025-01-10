<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class AccountModelTest extends CIUnitTestCase
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
    // * isUsernameTaken()
    // *************************************
    public function testIsUsernameTaken_UsernameExists_ReturnsTrue()
    {
        $model = new AccountModel();
        $this->assertTrue($model->isUsernameTaken('coder2k'));
    }

    public function testIsUsernameTaken_UsernameExists_CaseInsensitive_ReturnsTrue()
    {
        $model = new AccountModel();
        $this->assertTrue($model->isUsernameTaken('CoDeR2k'));
    }

    public function testIsUsernameTaken_UsernameDoesNotExist_ReturnsFalse()
    {
        $model = new AccountModel();
        $this->assertFalse($model->isUsernameTaken('user'));
    }

    // *************************************
    // * isEmailTaken()
    // *************************************
    public function testIsEmailTaken_EmailExists_ReturnsTrue()
    {
        $model = new AccountModel();
        $this->assertTrue($model->isEmailTaken('coder2k@test-conf.de'));
    }

    public function testIsEmailTaken_EmailExists_CaseInsensitive_ReturnsTrue()
    {
        $model = new AccountModel();
        $this->assertTrue($model->isEmailTaken('CoDeR2K@TeSt-CoNf.De'));
    }

    public function testIsEmailTaken_EmailDoesNotExist_ReturnsFalse()
    {
        $model = new AccountModel();
        $this->assertFalse($model->isEmailTaken('if@then.else'));
    }

    // *************************************
    // * createAccount()
    // *************************************
    public function testCreateAccount_ReturnsUserId()
    {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $userId = $model->createAccount($userId, 'r00tifant', password_hash('Arch', PASSWORD_DEFAULT), 'i_use@arch.btw');
        $this->assertEquals(4, $userId);
    }

    public function testCreateAccount_DuplicateUsernameAndEmail_ReturnsFalse()
    {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $this->assertFalse($model->createAccount($userId, 'coder2k', password_hash('stan', PASSWORD_DEFAULT), 'coder2k@test-conf.de'));
    }

    public function testCreateAccount_DuplicateUsernameAndEmail_CaseInsensitive_ReturnsFalse()
    {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $this->assertFalse($model->createAccount($userId, 'CoDer2k', password_hash('stan', PASSWORD_DEFAULT), 'CoDER2K@test-conf.de'));
    }

    public function testCreateAccount_DuplicateUsername_ReturnsFalse()
    {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $this->assertFalse($model->createAccount($userId, 'coder2k', password_hash('stan', PASSWORD_DEFAULT), 'somebody@test-conf.de'));
    }

    public function testCreateAccount_DuplicateUsername_CaseInsensitive_ReturnsFalse()
    {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $this->assertFalse($model->createAccount($userId, 'CoDeR2k', password_hash('stan', PASSWORD_DEFAULT), 'somebody@test-conf.de'));
    }

    public function testCreateAccount_DuplicateEmail_ReturnsFalse()
    {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $this->assertFalse($model->createAccount($userId, 'Somebody', password_hash('stan', PASSWORD_DEFAULT), 'coder2k@test-conf.de'));
    }

    public function testCreateAccount_DuplicateEmail_CaseInsensitive_ReturnsFalse()
    {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $this->assertFalse($model->createAccount($userId, 'Somebody', password_hash('stan', PASSWORD_DEFAULT), 'CoDeR2k@test-conf.de'));
    }

    public function testCreateAccount_TakenUserId_ReturnsFalse()
    {
        $model = new AccountModel();
        $this->assertFalse($model->createAccount(1, 'Me', password_hash('stan', PASSWORD_DEFAULT), 'me@test-conf.de'));
    }

    // *************************************
    // * getAccountByUsernameOrEmail()
    // *************************************
    public function testGetAccountByUsernameOrEmail_UsernameExists_ReturnsArray()
    {
        $model = new AccountModel();
        $result = $model->getAccountByUsernameOrEmail('coder2k');
        $this->assertIsArray($result);
        $this->assertEquals('coder2k', $result['username']);
        $this->assertTrue($model->checkPassword($result['user_id'], 'Coder2k123!'));
        $this->assertEquals('coder2k@test-conf.de', $result['email']);
    }

    public function testGetAccountByUsernameOrEmail_UsernameExists_CaseInsensitive_ReturnsArray()
    {
        $model = new AccountModel();
        $result = $model->getAccountByUsernameOrEmail('CoDeR2k');
        $this->assertIsArray($result);
        $this->assertEquals('coder2k', $result['username']);
        $this->assertTrue($model->checkPassword($result['user_id'], 'Coder2k123!'));
        $this->assertEquals('coder2k@test-conf.de', $result['email']);
    }

    public function testGetAccountByUsernameOrEmail_EmailExists_ReturnsArray()
    {
        $model = new AccountModel();
        $result = $model->getAccountByUsernameOrEmail('coder2k@test-conf.de');
        $this->assertIsArray($result);
        $this->assertEquals('coder2k', $result['username']);
        $this->assertTrue($model->checkPassword($result['user_id'], 'Coder2k123!'));
        $this->assertEquals('coder2k@test-conf.de', $result['email']);
    }

    public function testGetAccountByUsernameOrEmail_EmailExists_CaseInsensitive_ReturnsArray()
    {
        $model = new AccountModel();
        $result = $model->getAccountByUsernameOrEmail('CoDeR2k@TEST-conf.de');
        $this->assertIsArray($result);
        $this->assertEquals('coder2k', $result['username']);
        $this->assertTrue($model->checkPassword($result['user_id'], 'Coder2k123!'));
        $this->assertEquals('coder2k@test-conf.de', $result['email']);
    }

    public function testGetAccountByUsernameOrEmail_UsernameDoesNotExist_ReturnsNull()
    {
        $model = new AccountModel();
        $this->assertNull($model->getAccountByUsernameOrEmail('user'));
    }

    public function testGetAccountByUsernameOrEmail_EmailDoesNotExist_ReturnsNull()
    {
        $model = new AccountModel();
        $this->assertNull($model->getAccountByUsernameOrEmail('does@not.exist'));
    }
}
