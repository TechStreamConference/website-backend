<?php

namespace App\Controllers;

use App\Models\SocialMediaLinkModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserDashboard extends BaseController
{
    private const SOCIAL_MEDIA_LINK_CREATION_RULES = [
        'social_media_type_id' => 'required|is_natural_no_zero',
        'url' => 'required|valid_url',
    ];

    private const SOCIAL_MEDIA_LINK_UPDATE_RULES = [
        'id' => 'required|is_natural_no_zero',
        'url' => 'required|valid_url',
    ];

    /** For each type of social media link, this function returns the most recent link
     * for the currently logged in user, regardless of whether it has already been approved
     * or not.
     * @return ResponseInterface The response to return to the client.
     */
    public function get(): ResponseInterface
    {
        $model = model(SocialMediaLinkModel::class);
        return $this->response->setJSON($model->getLatestForUser($this->getLoggedInUserId()));
    }

    /** This function creates a new social media link for the currently logged in user.
     * @return ResponseInterface The response to return to the client.
     */
    public function create(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data, self::SOCIAL_MEDIA_LINK_CREATION_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $model = model(SocialMediaLinkModel::class);

        // Check if there already is a social media link of the same type with the same URL.
        $userId = $this->getLoggedInUserId();
        $existingLink = $model->getByLinkTypeAndUserId($validData['social_media_type_id'], $userId);
        if ($existingLink !== null && $existingLink['url'] === $validData['url']) {
            return $this
                ->response
                ->setJSON(['error' => 'A social media link with the same contents already exists.'])
                ->setStatusCode(400);
        }

        $model->create(
            $validData['social_media_type_id'],
            $userId,
            $validData['url'],
            false,
        );

        return $this->response->setStatusCode(201);
    }

    /** This function updates an existing social media link for the currently logged in user.
     * @return ResponseInterface The response to return to the client.
     */
    public function update(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data, self::SOCIAL_MEDIA_LINK_UPDATE_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $model = model(SocialMediaLinkModel::class);

        // Check if the social media link exists and belongs to the currently logged in user.
        $userId = $this->getLoggedInUserId();
        $link = $model->get($validData['id']);
        if ($link === null || $link['user_id'] !== $userId) {
            return $this
                ->response
                ->setJSON(['error' => 'Social media link not found or does not belong to the currently logged in user.'])
                ->setStatusCode(404);
        }

        if ($link['url'] === $validData['url']) {
            return $this
                ->response
                ->setJSON(['error' => 'The new URL is the same as the old one.'])
                ->setStatusCode(400);
        }

        $model->updateLink(
            $link['id'],
            $link['social_media_type_id'],
            $userId,
            $validData['url'],
            false,
            null,
        );

        return $this
            ->response
            ->setJSON(['message' => 'Link updated.'])
            ->setStatusCode(204);
    }

    /** This function returns the ID of the currently logged in user. We don't check their role here.
     * @return int The ID of the currently logged in user.
     */
    private function getLoggedInUserId(): int
    {
        $session = session();
        return $session->get('user_id');
    }
}
