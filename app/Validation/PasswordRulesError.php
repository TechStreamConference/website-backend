<?php

namespace App\Validation;

enum PasswordRulesError: string
{
    case PasswordMissingField = 'PASSWORD_MISSING_FIELD';
    case PasswordTooShort = 'PASSWORD_TOO_SHORT';
    case PasswordMissingLowercaseLetter = 'PASSWORD_MISSING_LOWERCASE_LETTER';
    case PasswordMissingUppercaseLetter = 'PASSWORD_MISSING_UPPERCASE_LETTER';
    case PasswordMissingNumber = 'PASSWORD_MISSING_NUMBER';
    case PasswordMissingSpecialCharacter = 'PASSWORD_MISSING_SPECIAL_CHARACTER';
}
