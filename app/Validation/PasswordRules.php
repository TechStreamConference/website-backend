<?php

namespace App\Validation;

class PasswordRules
{
    const PASSWORD_MIN_LENGTH = 8;

    public function valid_password(string $password, ?string &$error = null): bool
    {
        if ($password === '') {
            $error = PasswordRulesError::PasswordMissingField->value;
            return false;
        }

        if (mb_strlen($password) < self::PASSWORD_MIN_LENGTH) {
            $error = PasswordRulesError::PasswordTooShort->value;
            return false;
        }

        $regex_lowercase = '/\p{Ll}/';
        $regex_uppercase = '/\p{Lu}/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~ ]/';

        if (preg_match_all($regex_lowercase, $password) < 1) {
            $error = PasswordRulesError::PasswordMissingLowercaseLetter->value;
            return false;
        }

        if (preg_match_all($regex_uppercase, $password) < 1) {
            $error = PasswordRulesError::PasswordMissingUppercaseLetter->value;
            return false;
        }

        if (preg_match_all($regex_number, $password) < 1) {
            $error = PasswordRulesError::PasswordMissingNumber->value;
            return false;
        }

        if (preg_match_all($regex_special, $password) < 1) {
            $error = PasswordRulesError::PasswordMissingSpecialCharacter->value;
            return false;
        }

        return true;
    }
}
