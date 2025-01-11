<?php

namespace App\Models;

use CodeIgniter\Model;

class TalkDurationChoiceModel extends Model
{
    protected $table = 'TalkDurationChoice';
    protected $allowedFields = [
        'duration',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $useTimestamps = true;
    protected array $casts = [
        'duration' => 'int',
    ];

    public function getAll(): array
    {
        return array_column($this->select('duration')->orderBy('duration')->findAll(), 'duration');
    }

    public function add(int $duration): void
    {
        $this->insert(['duration' => $duration]);
    }
}
