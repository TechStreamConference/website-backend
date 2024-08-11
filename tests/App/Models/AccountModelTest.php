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

    public function testIsUsernameTaken()
    {
        $model = new AccountModel();
        $this->assertTrue($model->isUsernameTaken('coder2k'));
        $this->assertFalse($model->isUsernameTaken('user'));
    }

    public function testIsEmailTaken()
    {
        $model = new AccountModel();
        $this->assertTrue($model->isEmailTaken('coder2k@test-conf.de'));
        $this->assertFalse($model->isEmailTaken('if@then.else'));
    }

    public function testCreateAccount()
    {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $userId = $model->createAccount($userId, 'GyrosGeier', password_hash('stan', PASSWORD_DEFAULT), 'stan@geier.de');
        $this->assertEquals(2, $userId);
    }

    public function testCreateAccountFailsUponDuplicateUsernameAndEmail() {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $this->assertFalse($model->createAccount($userId, 'coder2k', password_hash('stan', PASSWORD_DEFAULT), 'coder2k@test-conf.de'));
    }

    public function testCreateAccountFailsUponDuplicateUsernameAndEmailCaseInsensitive() {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $this->assertFalse($model->createAccount($userId, 'CoDer2k', password_hash('stan', PASSWORD_DEFAULT), 'CoDER2K@test-conf.de'));
    }

    public function testCreateAccountFailsUponDuplicateUsername() {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $this->assertFalse($model->createAccount($userId, 'coder2k', password_hash('stan', PASSWORD_DEFAULT), 'somebody@test-conf.de'));
    }

    public function testCreateAccountFailsUponDuplicateUsernameCaseInsensitive() {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $this->assertFalse($model->createAccount($userId, 'CoDeR2k', password_hash('stan', PASSWORD_DEFAULT), 'somebody@test-conf.de'));
    }

    public function testCreateAccountFailsUponDuplicateEmail() {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $this->assertFalse($model->createAccount($userId, 'Somebody', password_hash('stan', PASSWORD_DEFAULT), 'coder2k@test-conf.de'));
    }

    public function testCreateAccountFailsUponDuplicateEmailCaseInsensitive() {
        $userId = (new UserModel())->createUser();
        $model = new AccountModel();
        $this->assertFalse($model->createAccount($userId, 'Somebody', password_hash('stan', PASSWORD_DEFAULT), 'CoDeR2k@test-conf.de'));
    }

    public function testCreateAccountFailsUponDuplicateUserId() {
        $model = new AccountModel();
        $this->assertFalse($model->createAccount(1, 'Me', password_hash('stan', PASSWORD_DEFAULT), 'me@test-conf.de'));
    }

    public function testCreateUserAndAccount()
    {
        $model = new AccountModel();
        $userId = $model->createUserAndAccount('GyrosGeier', password_hash('stan', PASSWORD_DEFAULT), 'stan@geier.de');
        $this->assertEquals(2, $userId);
    }

    public function testCreateUserAndAccountFailsUponDuplicateUsername()
    {
        $model = new AccountModel();
        $this->assertFalse($model->createUserAndAccount('coder2k', password_hash('stan', PASSWORD_DEFAULT), 'stan@geier.de'));
    }

    public function testCreateUserAndAccountFailsUponDuplicateUsernameDifferentCapitalization()
    {
        $model = new AccountModel();
        $this->assertFalse($model->createUserAndAccount('Coder2k', password_hash('stan', PASSWORD_DEFAULT), 'stan@geier.de'));
    }

    public function testCreateUserAndAccountFailsUponDuplicateEmail()
    {
        $model = new AccountModel();
        $this->assertFalse($model->createUserAndAccount('GyrosGeier', password_hash('stan', PASSWORD_DEFAULT), 'coder2k@test-conf.de'));
    }

    public function testCreateUserAndAccountFailsUponDuplicateEmailDifferentCapitalization()
    {
        $model = new AccountModel();
        $this->assertFalse($model->createUserAndAccount('GyrosGeier', password_hash('stan', PASSWORD_DEFAULT), 'codeR2k@test-conf.de'));
    }
}
