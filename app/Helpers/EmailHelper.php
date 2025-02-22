<?php

namespace App\Helpers;

use App\Models\AccountModel;
use Config\Services;

class EmailHelper
{
    public static function send(
        string  $to,
        string  $subject,
        string  $message,
        ?string $replyTo = null
    ): bool
    {
        $email = Services::email();
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->setMailType('text');
        if ($replyTo !== null) {
            $email->setReplyTo($replyTo);
        }
        return $email->send();
    }

    public static function sendToAdmins(
        string  $subject,
        string  $message,
        ?string $replyTo = null
    ): bool
    {
        $model = model(AccountModel::class);
        $admins = $model->getAdmins();

        $success = true;
        foreach ($admins as $admin) {
            $success &= self::send($admin['email'], $subject, $message, $replyTo);
        }
        return $success;
    }
}
