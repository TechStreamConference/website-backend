<?php

namespace App\Controllers;

use App\Helpers\EmailHelper;
use App\Models\AccountModel;
use App\Models\GenericRoleModel;
use App\Models\SocialMediaLinkModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

/** Abstract base class for the dashboards of speakers and team members. */
abstract class ContributorDashboard extends BaseController
{
    // Everything is optional, but when creating a new entry, all fields must be valid
    // and filled. When only updating an entry, only the fields that are being updated
    // must be valid. In the latter case, this is checked within the respective method.
    private const RULES = [
        'name' => 'permit_empty|string|max_length[100]',
        'short_bio' => 'permit_empty|string|max_length[300]',
        'bio' => 'permit_empty|string',
        'photo_x' => 'permit_empty|integer',
        'photo_y' => 'permit_empty|integer',
        'photo_size' => 'permit_empty|integer',
    ];

    private const PHOTO_RULES = [
        'photo' => "is_image[photo]|mime_in[photo,image/png,image/jpeg]",
    ];

    // When creating a new entry, the following fields are required.
    private const REQUIRED_JSON_FIELDS = [
        'name',
        'short_bio',
        'bio',
        'photo_x',
        'photo_y',
        'photo_size',
    ];

    private const SOCIAL_MEDIA_LINK_CREATION_RULES = [
        'social_media_type_id' => 'required|is_natural_no_zero',
        'url' => 'required|valid_url',
    ];

    /* Expected JSON structure:
     * {
     *     "social_media_links": [
     *         {
     *             "id": 1,
     *             "social_media_type_id": 1,
     *             "url": "..."
     *         },
     *         {
     *             "id": 2,
     *             "social_media_type_id": 1,
     *             "url": "..."
     *         }
     *         ...
     *     ]
     * }
     */
    private const SOCIAL_MEDIA_LINK_UPDATE_RULES = [
        'social_media_links.*.id' => 'required|is_natural_no_zero',
        'social_media_links.*.social_media_type_id' => 'required|is_natural_no_zero',
        'social_media_links.*.url' => 'required|valid_url',
    ];

    // The following rules are used when bulk-creating new links. This happens during speaker application.
    private const APPLICATION_SOCIAL_MEDIA_LINK_RULES = [
        'social_media_links.*.social_media_type_id' => 'required|is_natural_no_zero',
        'social_media_links.*.url' => 'required|valid_url',
    ];

    abstract protected function getModelClassName(): string;

    abstract protected function getRoleName(): string;

    abstract protected function getRoleNameScreamingSnakeCase(): string;

    /** For each type of social media link, this function returns the most recent link
     * for the currently logged in user, regardless of whether it has already been approved
     * or not.
     * @return ResponseInterface The response to return to the client.
     */
    public function getLatestSocialMediaLinksForCurrentUser(): ResponseInterface
    {
        $model = model(SocialMediaLinkModel::class);
        return $this->response->setJSON($model->getLatestForUser($this->getLoggedInUserId()));
    }

    /** This function creates a new social media link for the currently logged in user.
     * @return ResponseInterface The response to return to the client.
     */
    public function createSocialMediaLinkForCurrentUser(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::SOCIAL_MEDIA_LINK_CREATION_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        $model = model(SocialMediaLinkModel::class);

        // Check if there already is a social media link of the same type with the same URL.
        $userId = $this->getLoggedInUserId();
        $existingLink = $model->getByLinkTypeAndUserId($validData['social_media_type_id'], $userId);
        if ($existingLink !== null && $existingLink['url'] === $validData['url']) {
            // A social media link with the same contents already exists.
            return $this
                ->response
                ->setJSON(['error' => 'DUPLICATE_SOCIAL_MEDIA_LINK_CONTENTS'])
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

    /** This function creates new social media links for the currently logged in user.
     * It is used when the user applies as a speaker.
     * @return ResponseInterface The response to return to the client.
     */
    protected function createSocialMediaLinksForCurrentUser(): ResponseInterface
    {
        $data = $this->getJsonFromMultipartRequest();
        if ($data instanceof ResponseInterface) {
            return $data;
        }
        if (!$this->validateData($data ?? [], self::APPLICATION_SOCIAL_MEDIA_LINK_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();
        $links = $validData['social_media_links'];

        $model = model(SocialMediaLinkModel::class);

        $userId = $this->getLoggedInUserId();
        foreach ($links as $link) {
            $model->create(
                $link['social_media_type_id'],
                $userId,
                $link['url'],
                false,
            );
        }

        return $this->response->setStatusCode(201);
    }

    /** This function updates existing social media links for the currently logged in user.
     * @return ResponseInterface The response to return to the client.
     */
    public function updateSocialMediaLinksForCurrentUser(): ResponseInterface
    {
        $data = $this->request->getJSON(assoc: true);
        if (!$this->validateData($data ?? [], self::SOCIAL_MEDIA_LINK_UPDATE_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();
        $links = $validData['social_media_links'];

        // Check for duplicate IDs.
        $linksToUpdate = array_column($links, 'id');
        if (count($linksToUpdate) !== count(array_unique($linksToUpdate))) {
            // Duplicate IDs found in the request.
            return $this
                ->response
                ->setJSON(['error' => 'DUPLICATE_SOCIAL_MEDIA_LINK_IDS'])
                ->setStatusCode(400);
        }

        $model = model(SocialMediaLinkModel::class);

        $userId = $this->getLoggedInUserId();
        $existingEntries = $model->getByUserId($userId);
        foreach ($links as &$link) {
            // Check if the social media link exists and belongs to the currently logged in user.
            $existingLink = null;
            foreach ($existingEntries as $entry) {
                if ($entry['id'] === $link['id']) {
                    $existingLink = $entry;
                    break;
                }
            }
            if ($existingLink === null) {
                // Social media link not found or does not belong to the currently logged in user.
                return $this
                    ->response
                    ->setJSON(['error' => 'SOCIAL_MEDIA_LINK_NOT_FOUND'])
                    ->setStatusCode(404);
            }

            $link['has_changed'] = $existingLink['url'] !== $link['url']
                || $existingLink['social_media_type_id'] !== $link['social_media_type_id'];
        }

        // All links are valid. Update them if they contain changes.
        unset($link);
        foreach ($links as $link) {
            if (!$link['has_changed']) {
                continue;
            }

            $model->updateLink(
                $link['id'],
                $link['social_media_type_id'],
                $userId,
                $link['url'],
                false,
                null,
            );
        }

        $accountModel = model(AccountModel::class);
        $account = $accountModel->get($userId);
        $username = $account['username'];

        EmailHelper::sendToAdmins(
            subject: "Änderung der Social-Media-Links",
            message: view(
                'email/admin/social_media_links_changed',
                [
                    'username' => $username,
                ],
            )
        );

        return $this
            ->response
            ->setStatusCode(204);
    }

    public function deleteSocialMediaLink(int $id): ResponseInterface
    {
        $model = model(SocialMediaLinkModel::class);
        $userId = $this->getLoggedInUserId();
        $link = $model->get($id);
        if ($link === null || $link['user_id'] !== $userId) {
            return $this->response->setStatusCode(404);
        }

        $model->delete($id);
        return $this->response->setStatusCode(204);
    }

    /** Returns the latest entry for the current contributor type for the given event.
     * @param int $eventId The ID of the event for which the entry is retrieved.
     * @return ResponseInterface
     */
    public function get(int $eventId): ResponseInterface
    {
        $model = $this->getModel();
        $entry = $model->getLatestForEvent(userId: $this->getLoggedInUserId(), eventId: $eventId);
        if ($entry === null) {
            // Entry not found for given event.
            return $this
                ->response
                ->setJSON(['error' => "{$this->getRoleNameScreamingSnakeCase()}_NOT_FOUND_FOR_EVENT"])
                ->setStatusCode(404);
        }

        return $this
            ->response
            ->setJSON($entry);
    }

    /** Returns all events for which the current contributor type has an entry.
     * @return ResponseInterface
     */
    public function getAll(): ResponseInterface
    {
        $model = $this->getModel();
        $entries = $model->getAllForUser(userId: $this->getLoggedInUserId());
        return $this
            ->response
            ->setJSON($entries);
    }

    protected function getJsonFromMultipartRequest(): array|ResponseInterface
    {
        $data = $this->request->getPost('json');
        if ($data === null) {
            return $this
                ->response
                ->setJSON(['error' => 'INVALID_JSON'])
                ->setStatusCode(400);
        }
        $data = json_decode($data, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            return $this
                ->response
                ->setJSON(['error' => 'INVALID_JSON'])
                ->setStatusCode(400);
        }
        return $data;
    }

    /** Extracts the JSON data from the request. If the data is invalid, it returns a response
     * with an error status code. If the data is valid, it returns the data as an associative array.
     * @return array|ResponseInterface The JSON data as an associative array, or a response with a 400 status code.
     */
    private function getJsonData(): array|ResponseInterface
    {
        // We don't know if this is a multipart request or not, so we have to check both.
        try {
            return $this->request->getJSON(assoc: true);
        } catch (\Exception) {
            // This is not a JSON request, but it still might be a multipart request.
        }
        return $this->getJsonFromMultipartRequest();
    }

    /**
     * Creates a new entry or updates an existing one. If an entry already exists, only the fields
     * that are being updated are required. If no entry exists yet, all fields are required.
     * @param int $eventId The ID of the event for which the entry is created or updated.
     * @return ResponseInterface
     */
    public function createOrUpdate(int $eventId): ResponseInterface
    {
        $data = $this->getJsonData();
        if ($data instanceof ResponseInterface) {
            return $data;
        }
        if (!$this->validateData($data ?? [], self::RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        $validData = $this->validator->getValidated();

        // First, we have to check if there's an existing entry for the given event. If not,
        // we have to check that all fields are filled.
        $model = $this->getModel();
        $entry = $model->getLatestForEvent(userId: $this->getLoggedInUserId(), eventId: $eventId);
        if ($entry === null) {
            return $this->createNewEntry($validData, $eventId);
        }
        if (!$this->hasChanges($validData, $entry)) {
            return $this
                ->response
                ->setJSON(['error' => 'NO_CHANGES_DETECTED'])
                ->setStatusCode(400);
        }

        EmailHelper::sendToAdmins(
            subject: "{$this->getRoleName()}-Eintrag geändert",
            message: view(
                'email/admin/contributor_entry_changed',
                [
                    'role' => $this->getRoleName(),
                    'username' => $entry['name'],
                ],
            )
        );

        return $this->updateEntry($validData, $entry, $eventId);
    }

    /** Checks if the given data has changes compared to the existing entry.
     * @param array $newData The data to check.
     * @param array $existingEntry The existing entry.
     * @return bool True if the data has changes, false otherwise.
     */
    private function hasChanges(array $newData, array $existingEntry): bool
    {
        $image = $this->request->getFile('photo');
        if ($image !== null) {
            return true;
        }

        foreach ($newData as $key => $value) {
            if ($value !== $existingEntry[$key]) {
                return true;
            }
        }
        return false;
    }

    /** Creates a new entry for the current contributor type. This function is called when no entry
     *  exists yet for the given event. All fields are required when creating a new entry.
     * @param array $validData
     * @param int $eventId
     * @return ResponseInterface
     */
    protected function createNewEntry(array $validData, int $eventId): ResponseInterface
    {
        // Check if all required fields are present.
        foreach (self::REQUIRED_JSON_FIELDS as $field) {
            if (!array_key_exists($field, $validData)) {
                return $this
                    ->response
                    ->setJSON([
                        'error' => "{$this->getRoleNameScreamingSnakeCase()}_CREATION_REQUIRES_ALL_FIELDS",
                        'missing_field' => $field,
                    ])
                    ->setStatusCode(400);
            }
        }
        $image = $this->request->getFile('photo');
        if ($image === null) {
            return $this->response->setJSON(['error' => 'IMAGE_MISSING'])->setStatusCode(400);
        }
        $uploadResult = $this->uploadPhoto(
            $image,
            $validData['photo_x'],
            $validData['photo_y'],
            $validData['photo_size'],
        );
        if ($uploadResult instanceof ResponseInterface) {
            return $this
                ->response
                ->setJSON(['error' => $uploadResult])
                ->setStatusCode(400);
        }
        [$path, $mimeType] = $uploadResult;
        $this->getModel()->create(
            name: $validData['name'],
            userId: $this->getLoggedInUserId(),
            eventId: $eventId,
            shortBio: $validData['short_bio'],
            bio: $validData['bio'],
            photo: $path,
            photoMimeType: $mimeType,
            isApproved: false,
            visibleFrom: null,
        );
        return $this
            ->response
            ->setJSON(['message' => "Created new {$this->getRoleName()} entry."])
            ->setStatusCode(201);
    }

    /** Updates an existing entry for the current contributor type. This function is called when an entry
     *  already exists for the given event. Only the fields that are being updated are required.
     *  Technically speaking, we still create a new entry, but we copy the values from the existing entry
     *  for the fields that are not being updated.
     * @param array $validData
     * @param array $existingEntry
     * @param int $eventId
     * @return ResponseInterface
     */
    public function updateEntry(array $validData, array $existingEntry, int $eventId): ResponseInterface
    {
        // If there's an existing entry, we *still* want to create a new entry, but only with the fields
        // that are being updated. For the other fields, we copy the values from the existing entry.
        $image = $this->request->getFile('photo');
        $wasPhotoUploaded = $image !== null;

        $uploadResult = null;
        $hasPhoto = false;
        if ($wasPhotoUploaded) {
            if (!isset($validData['photo_x'], $validData['photo_y'], $validData['photo_size'])) {
                return $this
                    ->response
                    ->setJSON(['error' => 'MISSING_PHOTO_DIMENSIONS'])
                    ->setStatusCode(400);
            }
            $uploadResult = $this->uploadPhoto(
                $image,
                $validData['photo_x'],
                $validData['photo_y'],
                $validData['photo_size'],
            );
            if ($uploadResult instanceof ResponseInterface) {
                return $uploadResult;
            }
            $hasPhoto = true;
        }
        $path = $hasPhoto ? $uploadResult[0] : null;
        $mimeType = $hasPhoto ? $uploadResult[1] : null;

        $this->getModel()->create(
            name: $validData['name'] ?? $existingEntry['name'],
            userId: $this->getLoggedInUserId(),
            eventId: $eventId,
            shortBio: $validData['short_bio'] ?? $existingEntry['short_bio'],
            bio: $validData['bio'] ?? $existingEntry['bio'],
            photo: $hasPhoto ? $path : $existingEntry['photo'],
            photoMimeType: $hasPhoto ? $mimeType : $existingEntry['photo_mime_type'],
            isApproved: false,
            visibleFrom: $existingEntry['visible_from'] ?? null,
        );
        return $this
            ->response
            ->setJSON(['message' => "Based new {$this->getRoleName()} entry on existing entry."])
            ->setStatusCode(201);
    }

    /** Extracts the allowed MIME types from the validation rules.
     * @return array The allowed MIME types.
     */
    private function getAllowedMimeTypes(): array
    {
        preg_match('/mime_in\[photo,(.*)]/', self::PHOTO_RULES['photo'], $matches);
        return explode(',', $matches[1]);
    }

    /** Returns the model for the current contributor type.
     * @return GenericRoleModel The model for the current contributor type.
     */
    protected function getModel(): GenericRoleModel
    {
        $model = model($this->getModelClassName());
        if (!$model instanceof GenericRoleModel) {
            throw new RuntimeException("Invalid model class name.");
        }
        return $model;
    }

    /** This function uploads the photo of the contributor. It returns the path to the uploaded file
     * and the MIME type of the file. If an error occurs, it returns a string with an error message.
     * @return array|string The path to the uploaded file and the MIME type, or an error message.
     */
    private function uploadPhoto(UploadedFile $fileId, int $x, int $y, int $size): array|ResponseInterface
    {
        if (!$this->validateData([], self::PHOTO_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        if ($fileId->hasMoved()) {
            return $this->response->setJSON(['error' => 'IMAGE_HAS_MOVED'])->setStatusCode(400);
        }
        $mimeType = $fileId->getMimeType();
        if (!in_array($mimeType, $this->getAllowedMimeTypes())) {
            return $this->response->setJSON(['error' => 'INVALID_MIME_TYPE'])->setStatusCode(400);
        }

        $filename = $fileId->getRandomName();
        $targetPath = WRITEPATH . 'uploads';

        if (!$fileId->move(targetPath: $targetPath, name: $filename)) {
            return $this->response->setJSON(['error' => 'FAILED_TO_MOVE_IMAGE'])->setStatusCode(400);
        }

        $filePath = $targetPath . DIRECTORY_SEPARATOR . $filename;

        // Crop image according to the given dimensions and scale it down to 350x350 pixels.
        $image = service('image');
        $image
            ->withFile($filePath)
            ->flatten(20, 20, 20)
            ->crop($size, $size, $x, $y)
            ->resize(350, 350, true)
            ->save($filePath);

        // Get the resolution.
        $imageInfo = getimagesize($filePath);
        if ($imageInfo === false) {
            return $this->response->setJSON(['error' => 'FAILED_TO_GET_IMAGE_RESOLUTION'])->setStatusCode(400);
        }
        [$width, $height] = $imageInfo;
        if ($width != $height) {
            unlink($filePath);
            return $this->response->setJSON(['error' => 'IMAGE_MUST_BE_SQUARE'])->setStatusCode(400);
        }

        $pathForDatabase = 'images' . DIRECTORY_SEPARATOR . $filename;
        return [$pathForDatabase, $mimeType];
    }
}
