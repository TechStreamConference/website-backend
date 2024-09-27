<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialMediaTypeModel extends Model
{
    protected $table = 'SocialMediaType';
    protected $allowedFields = ['name', 'icon', 'icon_mime_type'];
    protected $useTimestamps = true;

    public function all(): array
    {
        return $this->select('id, name')->findAll();
    }
}
