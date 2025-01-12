<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\ResponseInterface;

class Image extends BaseController
{
    public function get(string $filename)
    {
        $path = $this->getPath($filename);
        if ($path instanceof ResponseInterface) {
            return $path;
        }
        $file = new File($path);
        $mimeType = $file->getMimeType();
        $this->response->setHeader('Content-Type', $mimeType);
        return $this->response->setBody(file_get_contents($path));
    }

    public function delete(string $filename)
    {
        $path = $this->getPath($filename);
        if ($path instanceof ResponseInterface) {
            return $path;
        }
        unlink($path);
        return $this->response->setStatusCode(204);
    }

    private function getPath(string $filename): string|ResponseInterface
    {
        // prevent path traversal (even though CodeIgniter should already prevent this)
        $path = realpath(WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . $filename);
        if ($path === false) {
            return $this->response->setStatusCode(400);
        }
        if (!str_starts_with($path, realpath(WRITEPATH . 'uploads'))) {
            return $this->response->setStatusCode(400);
        }
        if (!file_exists($path)) {
            return $this->response->setStatusCode(404);
        }
        return $path;
    }
}
