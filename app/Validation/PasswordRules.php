<?php

namespace App\Validation;

class PasswordRules
{
    public function valid_password(string $password, ?string &$error = null): bool {
        if ($password === '') {
            $error = lang('Validation.missingField', ['field' => lang('Validation.password')]);
            return false;
        }

        if (mb_strlen($password) < 8) {
            $error = lang('Validation.tooShort', ['field' => lang('Validation.password')]);
            return false;
        }

        $regex_lowercase = '/\p{Ll}/';
        $regex_uppercase = '/\p{Lu}/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~ ]/';

        if (preg_match_all($regex_lowercase, $password) < 1)
        {
            $error = lang('Validation.missingLowercaseLetter', ['field' => lang('Validation.password')]);
            return false;
        }

        if (preg_match_all($regex_uppercase, $password) < 1)
        {
            $error = lang('Validation.missingUppercaseLetter', ['field' => lang('Validation.password')]);
            return false;
        }

        if (preg_match_all($regex_number, $password) < 1)
        {
            $error = lang('Validation.missingNumber', ['field' => lang('Validation.password')]);
            return false;
        }

        if (preg_match_all($regex_special, $password) < 1)
        {
            $error = lang('Validation.missingSpecialCharacter', ['field' => lang('Validation.password')]);
            return false;
        }

        return true;
    }
}
