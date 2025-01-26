<?php

namespace App\Controllers;

use App\Helpers\PathHelper;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\ResponseInterface;

class Image extends BaseController
{
    public function get(string $filename): ResponseInterface
    {
        $path = PathHelper::getImagePath($filename);
        if ($path == null) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        $file = new File($path);
        $mimeType = $file->getMimeType();
        $this->response->setHeader('Content-Type', $mimeType);
        return $this->response->setBody(file_get_contents($path));
    }
}
