<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialMediaTypeModel extends Model
{
    protected $table = 'SocialMediaType';
    protected $allowedFields = ['name', 'icon', 'icon_mime_type'];
    protected array $casts = [
        'id' => 'int',
    ];
    protected $useTimestamps = true;

    public function all(): array
    {
        return $this
            ->select('id, name')
            ->orderBy('name')
            ->findAll();
    }

    public function create(string $name): int
    {
        return $this->insert(['name' => $name]);
    }
}
