<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use CodeIgniter\HTTP\ResponseInterface;

class Image extends BaseController
{
    public function get(string $filename): ResponseInterface
    {
        // prevent path traversal (even though CodeIgniter should already prevent this)
        $path = realpath(WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . $filename);
        if ($path === false) {
            return $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        if (!str_starts_with($path, realpath(WRITEPATH . 'uploads'))) {
            return $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        if (!file_exists($path)) {
            return $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        $file = new File($path);
        $mimeType = $file->getMimeType();
        $this->response->setHeader('Content-Type', $mimeType);
        return $this->response->setBody(file_get_contents($path));
    }
}
