<?php

namespace App\Controllers;

use App\Models\SocialMediaLinkModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserDashboard extends BaseController
{
    private const SOCIAL_MEDIA_RULES = [
        'social_media_type_id' => 'required|is_natural_no_zero',
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
        // TODO: Only create a new entry if it differs from the latest existing entry.
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data, self::SOCIAL_MEDIA_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $model = model(SocialMediaLinkModel::class);
        $model->create(
            $validData['social_media_type_id'],
            $this->getLoggedInUserId(),
            $validData['url'],
            false,
        );

        return $this->response->setStatusCode(201);
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
