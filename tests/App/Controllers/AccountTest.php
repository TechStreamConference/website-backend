<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class AccountTest extends CIUnitTestCase
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

    // *************************************
    // * register()
    // *************************************
    function testRegister_ValidCredentials_Returns201()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'c!3v3R35p455W0rd',
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(201);
    }

    function testRegister_InvalidEmail_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'StrahlMarschall',
            'password' => 'l!gatur3S',
            'email' => 'rayferris.rs', // invalid email
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact(['email' => 'The email field must contain a valid email address.']);
    }

    function testRegister_EmptyUsername_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => '', // empty username
            'password' => 'l1g4Tures!',
            'email' => 'ray@ferris.rs',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'username' => 'The username field is required.'
        ]);
    }

    function testRegister_UsernameTooShort_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'a', // username too short
            'password' => 'l!g4Tures',
            'email' => 'ray@ferris.rs',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'username' => 'The username field must be at least 3 characters in length.'
        ]);
    }

    function testRegister_TrimmedUsernameTooShort_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => '                                    a                       ', // username too short
            'password' => 'l!g4Tures',
            'email' => 'ray@ferris.rs',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'username' => 'The username field may only contain alphanumeric, underscore, and dash characters.'
        ]);
    }

    function testRegister_UsernameTooLong_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'thisusernameiswaytoolongandshouldnotbeaccepted', // username too long
            'password' => 'l!g4Tures',
            'email' => 'ray@ferris.rs',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'username' => 'The username field cannot exceed 30 characters in length.'
        ]);
    }

    function testRegister_UsernameWithSpecialCharacter_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => '*Das/Cleverle*', // username with special character
            'password' => 'c!3v3R35p455W0rd',
            'email' => 'das@cleverle.de',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'username' => 'The username field may only contain alphanumeric, underscore, and dash characters.'
        ]);
    }

    function testRegister_EmptyPassword_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => '', // empty password
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'The password field is required.'
        ]);
    }

    function testRegister_MissingSpecialCharacters_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'UPPERCASElowercase123', // missing special character
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'The password field must have at least one special character.'
        ]);
    }

    function testRegister_MissingUppercaseLetter_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'lowercase123!', // missing uppercase letter
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'The password field must be at least one uppercase letter.'
        ]);
    }

    function testRegister_MissingLowercaseLetter_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'UPPERCASE123!', // missing lowercase letter
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'The password field must be at least one lowercase letter.'
        ]);
    }

    function testRegister_MissingNumber_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'UPPERCASElowercase!', // missing number
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'The password field must have at least one number.'
        ]);
    }

    function testRegister_PasswordTooShort_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'l!g4T', // password too short
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'The password field must be at least 8 characters in length.'
        ]);
    }

    function testRegister_MissingUsername_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'password' => 'l!g4Tures',
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'username' => 'The username field is required.'
        ]);
    }

    function testRegister_MissingPassword_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'The password field is required.'
        ]);
    }

    function testRegister_MissingEmail_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'l!g4Tures',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'email' => 'The email field is required.'
        ]);
    }

    function testRegister_UsernameIsNull_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => null,
            'password' => 'l!g4Tures',
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'username' => 'The username field is required.'
        ]);
    }

    function testRegister_PasswordIsNull_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => null,
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'The password field is required.'
        ]);
    }

    function testRegister_EmailIsNull_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'l!g4Tures',
            'email' => null,
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'email' => 'The email field is required.'
        ]);
    }

    function testRegister_UsernameAlreadyTaken_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'coder2k',
            'password' => 'l!g4Tures',
            'email' => 'random@random.com',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'error' => 'Username or email already taken'
        ]);
    }

    function testRegister_UsernameAlreadyTaken_CaseInsensitive_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'cOdEr2K',
            'password' => 'l!g4Tures',
            'email' => 'random@random.com',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'error' => 'Username or email already taken'
        ]);
    }

    function testRegister_EmailAlreadyTaken_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'random',
            'password' => 'l!g4Tures',
            'email' => 'coder2k@test-conf.de',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'error' => 'Username or email already taken'
        ]);
    }

    function testRegister_EmailAlreadyTaken_CaseInsensitive_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'random',
            'password' => 'l!g4Tures',
            'email' => 'Coder2k@test-conf.de',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'error' => 'Username or email already taken'
        ]);
    }

    // *************************************
    // * usernameExists()
    // *************************************
    function testUsernameExists_ExactMatch_ReturnsTrue()
    {
        $result = $this->get('account/username/exists?username=coder2k');
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    static function providerCaseInsensitiveUsername(): array
    {
        return [
            ['Coder2k'],
            ['cOdEr2K'],
        ];
    }

    /**
     * @dataProvider providerCaseInsensitiveUsername
     */
    function testUsernameExists_CaseInsensitiveMatch_ReturnsTrue($username)
    {
        $result = $this->get("account/username/exists?username=$username");
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    function testUsernameExists_NoMatch_ReturnsFalse()
    {
        $result = $this->get('account/username/exists?username=user');
        $result->assertOK();
        $result->assertJSONExact(['exists' => false]);
    }

    static function providerUsernameWithSpace(): array
    {
        return [
            ['Gyros%20Geier'],
            ['Gyros+Geier'],
            ['Gyros Geier'],
        ];
    }

    /**
     * @dataProvider providerUsernameWithSpace
     */
    function testUsernameExists_UsernameWithSpace_ReturnsTrue($username)
    {
        $result = $this->get("account/username/exists?username=$username");
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    static function providerUsernameWithLeadingOrTrailingSpace(): array
    {
        return [
            ['coder2k '],
            [' coder2k'],
            [' coder2k '],
        ];
    }

    /**
     * @dataProvider providerUsernameWithLeadingOrTrailingSpace
     */
    function testUsernameExists_UsernameWithLeadingOrTrailingSpace_ReturnsTrue($username)
    {
        $result = $this->get("account/username/exists?username=$username");
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    function testUsernameExists_emptyUsername_Returns400()
    {
        $result = $this->get('account/username/exists?username=');
        $result->assertStatus(400);
    }

    function testUsernameExists_additionalGetParameter_ReturnsTrue()
    {
        $result = $this->get('account/username/exists?username=coder2k&hacker=1');
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    function testUsernameExists_noGetParameters_Returns400()
    {
        $result = $this->get('account/username/exists');
        $result->assertStatus(400);
    }

    // *************************************
    // * emailExists()
    // *************************************
    function testEmailExists_ExactMatch_ReturnsTrue()
    {
        $result = $this->get('account/email/exists?email=coder2k@test-conf.de');
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    function testEmailExists_CaseInsensitiveMatch_ReturnsTrue()
    {
        $result = $this->get('account/email/exists?email=Coder2k@test-conf.de');
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    function testEmailExists_NoMatch_ReturnsFalse()
    {
        $result = $this->get('account/email/exists?email=pedder@__.de');
        $result->assertOK();
        $result->assertJSONExact(['exists' => false]);
    }

    function testEmailExists_EmptyEmail_Returns400()
    {
        $result = $this->get('account/email/exists?email=');
        $result->assertStatus(400);
    }

    function testEmailExists_WrongGetParameter_Returns400()
    {
        $result = $this->get('account/email/exists?hacker=pedder@__.de');
        $result->assertStatus(400);
    }

    function testEmailExists_AdditionalGetParameter_ReturnsTrue()
    {
        $result = $this->get('account/email/exists?email=pedder@__.de&hacker=true');
        $result->assertOK();
        $result->assertJSONExact(['exists' => false]);
    }

    // *************************************
    // * login()
    // *************************************
    function testLogin_ValidCredentials_Returns200()
    {
        $result = $this->withBodyFormat('json')->post('account/login', [
            'username_or_email' => 'coder2k',
            'password' => 'password',
        ]);
        $result->assertStatus(200);
        $result->assertSessionHas('user_id');
    }

    function testLogin_UnknownUsernameOrEmail_Returns404()
    {
        $result = $this->withBodyFormat('json')->post('account/login', [
            'username_or_email' => 'unknown',
            'password' => 'password',
        ]);
        $result->assertStatus(404);
        $result->assertSessionMissing('user_id');
    }

    function testLogin_InvalidPassword_Returns401()
    {
        $result = $this->withBodyFormat('json')->post('account/login', [
            'username_or_email' => 'coder2k',
            'password' => 'wrongpassword',
        ]);
        $result->assertStatus(401);
        $result->assertSessionMissing('user_id');
    }

    function testLogin_MissingUsernameOrEmail_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/login', [
            'password' => 'password',
        ]);
        $result->assertStatus(400);
        $result->assertSessionMissing('user_id');
    }

    function testLogin_MissingPassword_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('account/login', [
            'username_or_email' => 'coder2k',
        ]);
        $result->assertStatus(400);
        $result->assertSessionMissing('user_id');
    }

    // *************************************
    // * logout()
    // *************************************
    function testLogout_LoggedIn_Returns200()
    {
        $this->withSession(['user_id' => 1]);
        $result = $this->post('account/logout');
        $result->assertStatus(200);
        $result->assertSessionMissing('user_id');
    }

    function testLogout_NotLoggedIn_Returns200()
    {
        $result = $this->post('account/logout');
        $result->assertStatus(200);
        $result->assertSessionMissing('user_id');
    }

    // *************************************
    // * roles()
    // *************************************
    function testRoles_UserHasAccount_Returns200()
    {
        $result = $this->get('account/roles?user_id=1');
        $result->assertStatus(200);
        $result->assertJSONExact(['has_account' => true]);
    }

    function testRoles_UserHasNoAccount_Returns200()
    {
        $result = $this->get('account/roles?user_id=3');
        $result->assertStatus(200);
        $result->assertJSONExact(['has_account' => false]);
    }

    function testRoles_UserDoesNotExist_Returns404()
    {
        $result = $this->get('account/roles?user_id=10');
        $result->assertStatus(404);
    }

    function testRoles_MissingUserId_Returns400()
    {
        $result = $this->get('account/roles');
        $result->assertStatus(400);
    }

    // *************************************
    // * get()
    // *************************************
    function testGet_LoggedIn_Returns200()
    {
        $this->withSession(['user_id' => 1]);
        $result = $this->get('account');
        $result->assertStatus(200);
        $result->assertJSONExact(['username' => 'coder2k', 'email' => 'coder2k@test-conf.de']);
    }

    function testGet_NotLoggedIn_Returns401()
    {
        $result = $this->get('account'); // won't reach controller because of AuthFilter
        $result->assertStatus(401);
    }

    function testGet_InvalidSession_Returns500()
    {
        $this->withSession(['user_id' => 10]);
        $result = $this->get('account');
        $result->assertStatus(500);
    }

    function testGet_InvalidUserId_Returns500()
    {
        $this->withSession(['user_id' => 3]);
        $result = $this->get('account');
        $result->assertStatus(500);
    }
}
