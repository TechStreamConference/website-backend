<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Files\File;

class Image extends BaseController
{
    public function get(string $filename)
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
        $file = new File($path);
        $mimeType = $file->getMimeType();
        $this->response->setHeader('Content-Type', $mimeType);
        return $this->response->setBody(file_get_contents($path));
    }
}
