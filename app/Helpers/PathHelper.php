<?php

namespace App\Helpers;

class PathHelper
{
    public static function getImagePath(string $filename): ?string
    {
        // prevent path traversal (even though CodeIgniter should already prevent this)
        $concatenated = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . $filename;
        $path = realpath($concatenated);
        if ($path === false) {
            return null;
        }
        if (!str_starts_with($path, realpath(WRITEPATH . 'uploads'))) {
            return null;
        }
        if (!file_exists($path)) {
            return null;
        }
        return $path;
    }
}
