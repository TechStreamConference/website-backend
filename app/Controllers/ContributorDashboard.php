<?php

namespace App\Controllers;

use App\Models\GenericRoleModel;
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
    ];

    private const PHOTO_RULES = [
        'photo' => "max_size[photo,1024]|max_dims[photo,500,500]|is_image[photo]|mime_in[photo,image/png,image/jpeg]",
    ];

    // When creating a new entry, the following fields are required.
    private const REQUIRED_JSON_FIELDS = ['name', 'short_bio', 'bio'];

    abstract protected function getModelClassName(): string;

    abstract protected function getRoleName(): string;

    public function get(int $eventId)
    {
        $model = $this->getModel();
        $entry = $model->getLatestForEvent(userId: $this->getLoggedInUserId(), eventId: $eventId);
        if ($entry === null) {
            return $this
                ->response
                ->setJSON([
                    'error' => "No {$this->getRoleName()} found for the given event."
                ])
                ->setStatusCode(404);
        }

        return $this
            ->response
            ->setJSON($entry);
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
        $jsonString = $this->request->getPost('json');
        if ($jsonString === null) {
            return $this
                ->response
                ->setJSON(['error' => 'Invalid JSON.'])
                ->setStatusCode(400);
        }
        $data = json_decode($jsonString, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            return $this
                ->response
                ->setJSON(['error' => 'Invalid JSON.'])
                ->setStatusCode(400);
        }
        return $data;
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
        if (!$this->validateData($data, self::RULES)) {
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
        return $this->updateEntry($validData, $entry, $eventId);

    }

    /** Creates a new entry for the current contributor type. This function is called when no entry
     *  exists yet for the given event. All fields are required when creating a new entry.
     * @param array $validData
     * @param int $eventId
     * @return ResponseInterface
     */
    private function createNewEntry(array $validData, int $eventId): ResponseInterface
    {
        // Check if all required fields are present.
        foreach (self::REQUIRED_JSON_FIELDS as $field) {
            if (!array_key_exists($field, $validData)) {
                return $this
                    ->response
                    ->setJSON([
                        'error' => "All fields are required when creating a new {$this->getRoleName()} entry. Missing field: $field."
                    ])
                    ->setStatusCode(400);
            }
        }
        $uploadResult = $this->uploadPhoto();
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
        $uploadResult = $this->uploadPhoto();
        $hasPhoto = !($uploadResult instanceof ResponseInterface);
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
            isApproved: $existingEntry['is_approved'],
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
    private function getModel(): GenericRoleModel
    {
        $model = model($this->getModelClassName());
        if (!$model instanceof GenericRoleModel) {
            throw new RuntimeException("Invalid model class name.");
        }
        return $model;
    }

    /** This function returns the ID of the currently logged in user. We don't check their role here.
     * @return int The ID of the currently logged in user.
     */
    private function getLoggedInUserId(): int
    {
        $session = session();
        return $session->get('user_id');
    }

    /** This function uploads the photo of the contributor. It returns the path to the uploaded file
     * and the MIME type of the file. If an error occurs, it returns a string with an error message.
     * @return array|string The path to the uploaded file and the MIME type, or an error message.
     */
    private function uploadPhoto(): array|ResponseInterface
    {
        $image = $this->request->getFile('photo');
        if ($image === null) {
            return $this->response->setJSON(['error' => 'No image uploaded.'])->setStatusCode(400);
        }
        if (!$this->validateData([], self::PHOTO_RULES)) {
            return $this->response->setJSON($this->validator->getErrors())->setStatusCode(400);
        }
        if ($image->hasMoved()) {
            return $this->response->setJSON(['error' => 'Image has moved.'])->setStatusCode(400);
        }
        $mimeType = $image->getMimeType();
        if (!in_array($mimeType, $this->getAllowedMimeTypes())) {
            return $this->response->setJSON(['error' => 'Invalid MIME type.'])->setStatusCode(400);
        }
        $filename = $image->getRandomName();
        if (!$image->move(targetPath: WRITEPATH . 'uploads', name: $filename)) {
            return $this->response->setJSON(['error' => 'Failed to move image.'])->setStatusCode(400);
        }
        $pathForDatabase = 'images' . DIRECTORY_SEPARATOR . $filename;
        return [$pathForDatabase, $mimeType];
    }
}
