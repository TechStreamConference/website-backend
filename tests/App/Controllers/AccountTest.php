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
        $result = $this->withBodyFormat('json')->post('register', [
            'username' => 'DasCleverle',
            'password' => 'c!3v3R35p455W0rd',
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(201);
    }

    function testRegister_InvalidEmail_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('register', [
            'username' => 'StrahlMarschall',
            'password' => 'l!gatur3S',
            'email' => 'rayferris.rs', // invalid email
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact(['email' => 'The email field must contain a valid email address.']);
    }

    function testRegister_EmptyUsername_Returns400()
    {
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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
        $result = $this->withBodyFormat('json')->post('register', [
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

    function testEmailExists_emptyEmail_Returns400()
    {
        $result = $this->get('account/email/exists?email=');
        $result->assertStatus(400);
    }

    function testEmailExists_wrongGetParameter_Returns400()
    {
        $result = $this->get('account/email/exists?hacker=pedder@__.de');
        $result->assertStatus(400);
    }

    function testEmailExists_additionalGetParameter_ReturnsTrue()
    {
        $result = $this->get('account/email/exists?email=pedder@__.de&hacker=true');
        $result->assertOK();
        $result->assertJSONExact(['exists' => false]);
    }
}
