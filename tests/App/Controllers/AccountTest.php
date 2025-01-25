<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use App\Database\Seeds\MainSeeder;

class AccountTest extends CIUnitTestCase
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

    // *************************************
    // * register()
    // *************************************
    public function testRegister_ValidCredentials_Returns201(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'c!3v3R35p455W0rd',
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(201);
    }

    public function testRegister_InvalidEmail_Returns400(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'StrahlMarschall',
            'password' => 'l!gatur3S',
            'email' => 'rayferris.rs', // invalid email
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact(['email' => 'The email field must contain a valid email address.']);
    }

    public function testRegister_EmptyUsername_Returns400(): void
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

    public function testRegister_UsernameTooShort_Returns400(): void
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

    public function testRegister_TrimmedUsernameTooShort_Returns400(): void
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

    public function testRegister_UsernameTooLong_Returns400(): void
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

    public function testRegister_UsernameWithSpecialCharacter_Returns400(): void
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

    public function testRegister_EmptyPassword_Returns400(): void
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

    public function testRegister_MissingSpecialCharacters_Returns400(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'UPPERCASElowercase123', // missing special character
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'PASSWORD_MISSING_SPECIAL_CHARACTER'
        ]);
    }

    public function testRegister_MissingUppercaseLetter_Returns400(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'lowercase123!', // missing uppercase letter
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'PASSWORD_MISSING_UPPERCASE_LETTER'
        ]);
    }

    public function testRegister_MissingLowercaseLetter_Returns400(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'UPPERCASE123!', // missing lowercase letter
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'PASSWORD_MISSING_LOWERCASE_LETTER'
        ]);
    }

    public function testRegister_MissingNumber_Returns400(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'UPPERCASElowercase!', // missing number
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'PASSWORD_MISSING_NUMBER'
        ]);
    }

    public function testRegister_PasswordTooShort_Returns400(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'DasCleverle',
            'password' => 'l!g4T', // password too short
            'email' => 'Das@Clever.le',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact([
            'password' => 'PASSWORD_TOO_SHORT'
        ]);
    }

    public function testRegister_MissingUsername_Returns400(): void
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

    public function testRegister_MissingPassword_Returns400(): void
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

    public function testRegister_MissingEmail_Returns400(): void
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

    public function testRegister_UsernameIsNull_Returns400(): void
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

    public function testRegister_PasswordIsNull_Returns400(): void
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

    public function testRegister_EmailIsNull_Returns400(): void
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

    public function testRegister_UsernameAlreadyTaken_Returns400(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'coder2k',
            'password' => 'l!g4Tures',
            'email' => 'random@random.com',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact(['error' => 'USERNAME_OR_EMAIL_ALREADY_TAKEN']);
    }

    public function testRegister_UsernameAlreadyTaken_CaseInsensitive_Returns400(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'cOdEr2K',
            'password' => 'l!g4Tures',
            'email' => 'random@random.com',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact(['error' => 'USERNAME_OR_EMAIL_ALREADY_TAKEN']);
    }

    public function testRegister_EmailAlreadyTaken_Returns400(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'random',
            'password' => 'l!g4Tures',
            'email' => 'coder2k@test-conf.de',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact(['error' => 'USERNAME_OR_EMAIL_ALREADY_TAKEN']);
    }

    public function testRegister_EmailAlreadyTaken_CaseInsensitive_Returns400(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'random',
            'password' => 'l!g4Tures',
            'email' => 'Coder2k@test-conf.de',
        ]);
        $result->assertStatus(400);
        $result->assertJSONExact(['error' => 'USERNAME_OR_EMAIL_ALREADY_TAKEN']);
    }

    public function testRegister_ExistingUser_ValidToken_Returns201(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'codingPurpurTentakel',
            'password' => 'CodingPurpurTentakel123!',
            'email' => 'tentakel@test-conf.de',
            'token' => 'd9f05f981302c5d8dcdd165cbd6b627ed33677207614e6fd6a1e9a68def5b6fd4180332e00475421e3bb7b6810bb2d1e6b6fa592cd613bee1b215b304a8a7b1a',
        ]);
        $result->assertStatus(201);
    }

    public function testRegister_ExistingUser_InvalidToken_Returns404(): void
    {
        $result = $this->withBodyFormat('json')->post('account/register', [
            'username' => 'codingPurpurTentakel',
            'password' => 'CodingPurpurTentakel123!',
            'email' => 'tentakel@test-conf.de',
            'token' => '123',
        ]);
        $result->assertStatus(404);
    }

    // *************************************
    // * usernameExists()
    // *************************************
    public function testUsernameExists_ExactMatch_ReturnsTrue(): void
    {
        $result = $this->get('account/username/exists?username=coder2k');
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    public static function providerCaseInsensitiveUsername(): array
    {
        return [
            ['Coder2k'],
            ['cOdEr2K'],
        ];
    }

    /**
     * @dataProvider providerCaseInsensitiveUsername
     */
    public function testUsernameExists_CaseInsensitiveMatch_ReturnsTrue($username): void
    {
        $result = $this->get("account/username/exists?username=$username");
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    public function testUsernameExists_NoMatch_ReturnsFalse(): void
    {
        $result = $this->get('account/username/exists?username=user');
        $result->assertOK();
        $result->assertJSONExact(['exists' => false]);
    }

    public static function providerUsernameWithSpace(): array
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
    public function testUsernameExists_UsernameWithSpace_ReturnsTrue($username): void
    {
        $result = $this->get("account/username/exists?username=$username");
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    public static function providerUsernameWithLeadingOrTrailingSpace(): array
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
    public function testUsernameExists_UsernameWithLeadingOrTrailingSpace_ReturnsTrue($username): void
    {
        $result = $this->get("account/username/exists?username=$username");
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    public function testUsernameExists_emptyUsername_Returns400(): void
    {
        $result = $this->get('account/username/exists?username=');
        $result->assertStatus(400);
    }

    public function testUsernameExists_additionalGetParameter_ReturnsTrue(): void
    {
        $result = $this->get('account/username/exists?username=coder2k&hacker=1');
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    public function testUsernameExists_noGetParameters_Returns400(): void
    {
        $result = $this->get('account/username/exists');
        $result->assertStatus(400);
    }

    // *************************************
    // * emailExists()
    // *************************************
    public function testEmailExists_ExactMatch_ReturnsTrue(): void
    {
        $result = $this->get('account/email/exists?email=coder2k@test-conf.de');
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    public function testEmailExists_CaseInsensitiveMatch_ReturnsTrue(): void
    {
        $result = $this->get('account/email/exists?email=Coder2k@test-conf.de');
        $result->assertOK();
        $result->assertJSONExact(['exists' => true]);
    }

    public function testEmailExists_NoMatch_ReturnsFalse(): void
    {
        $result = $this->get('account/email/exists?email=pedder@__.de');
        $result->assertOK();
        $result->assertJSONExact(['exists' => false]);
    }

    public function testEmailExists_EmptyEmail_Returns400(): void
    {
        $result = $this->get('account/email/exists?email=');
        $result->assertStatus(400);
    }

    public function testEmailExists_WrongGetParameter_Returns400(): void
    {
        $result = $this->get('account/email/exists?hacker=pedder@__.de');
        $result->assertStatus(400);
    }

    public function testEmailExists_AdditionalGetParameter_ReturnsTrue(): void
    {
        $result = $this->get('account/email/exists?email=pedder@__.de&hacker=true');
        $result->assertOK();
        $result->assertJSONExact(['exists' => false]);
    }

    // *************************************
    // * login()
    // *************************************
    public function testLogin_ValidCredentials_Returns200(): void
    {
        $result = $this->withBodyFormat('json')->post('account/login', [
            'username_or_email' => 'coder2k',
            'password' => 'Coder2k123!',
        ]);
        $result->assertStatus(200);
        $result->assertSessionHas('user_id');
    }

    public function testLogin_UnknownUsernameOrEmail_Returns404(): void
    {
        $result = $this->withBodyFormat('json')->post('account/login', [
            'username_or_email' => 'unknown',
            'password' => 'Password123!',
        ]);
        $result->assertStatus(404);
        $result->assertSessionMissing('user_id');
    }

    public function testLogin_InvalidPassword_Returns401(): void
    {
        $result = $this->withBodyFormat('json')->post('account/login', [
            'username_or_email' => 'coder2k',
            'password' => 'WrongPassword123!',
        ]);
        $result->assertStatus(401);
        $result->assertSessionMissing('user_id');
    }

    public function testLogin_MissingUsernameOrEmail_Returns400(): void
    {
        $result = $this->withBodyFormat('json')->post('account/login', [
            'password' => 'password',
        ]);
        $result->assertStatus(400);
        $result->assertSessionMissing('user_id');
    }

    public function testLogin_MissingPassword_Returns400(): void
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
    public function testLogout_LoggedIn_Returns200(): void
    {
        $this->withSession(['user_id' => 1]);
        $result = $this->post('account/logout');
        $result->assertStatus(200);
        $result->assertSessionMissing('user_id');
    }

    public function testLogout_NotLoggedIn_Returns200(): void
    {
        $result = $this->post('account/logout');
        $result->assertStatus(200);
        $result->assertSessionMissing('user_id');
    }
}
