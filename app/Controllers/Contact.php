<?php

namespace App\Controllers;

use App\Helpers\EmailHelper;
use CodeIgniter\HTTP\ResponseInterface;

class Contact extends BaseController
{
    private const CONTACT_RULES = [
        'name' => 'required',
        'email' => 'required|valid_email',
        'subject' => 'required|max_length[78]',
        'message' => 'required|max_length[2000]',
    ];

    public function send(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::CONTACT_RULES)) {
            return $this
                ->response
                ->setJSON($this->validator->getErrors())
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        $validData = $this->validator->getValidated();

        $name = $validData['name'];
        $email = $validData['email'];
        $subject = $this->sanitize($validData['subject']);
        $message = $validData['message'];

        if (
            !EmailHelper::sendToAdmins(
                subject: "Kontaktanfrage: \"$subject\"",
                message: view(
                    'email/contact/contact_message',
                    compact('name', 'email', 'subject', 'message')
                ),
                replyTo: $email,
            )
        ) {
            return $this
                ->response
                ->setJSON(['error' => 'SENDING_EMAIL_FAILED'])
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (
            !EmailHelper::send(
                to: $email,
                subject: 'Deine Kontaktanfrage an die Tech Stream Conference',
                message: view(
                    'email/contact/contact_message_confirmation',
                    compact('name', 'subject', 'message')
                ),
            )
        ) {
            return $this
                ->response
                ->setJSON(['error' => 'SENDING_CONFIRMATION_FAILED'])
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
    }

    private function sanitize(string $value): string
    {
        return esc(
            preg_replace(
                '/[\x00-\x1F\x7F]/',
                '',
                str_replace(
                    ["\r", "\n"],
                    '',
                    strip_tags($value)
                )
            )
        );
    }
}
