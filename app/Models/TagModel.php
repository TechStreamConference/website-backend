<?php

namespace App\Models;

use CodeIgniter\Model;

class TagModel extends Model
{
    protected $table = 'Tag';
    protected $allowedFields = [
        'id',
        'text',
        'color_index',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $useTimestamps = true;
    protected array $casts = [
        'color_index' => 'int',
    ];

    public function getAll(): array
    {
        return $this->orderBy('text')->findAll();
    }

    public function getAllByTalkIds(array $talkIds): array
    {
        $result = $this
            ->db
            ->table('Talk')
            ->select('Talk.id as talk_id, Tag.color_index, Tag.text')
            ->whereIn('Talk.id', $talkIds)
            ->join('TalkHasTag', 'TalkHasTag.talk_id = Talk.id')
            ->join('Tag', 'Tag.id = TalkHasTag.tag_id')
            ->get()
            ->getResultArray();

        // Automatic casts won't work because we are using a query on another table.
        foreach ($result as &$row) {
            $row['color_index'] = (int)$row['color_index'];
        }

        return $result;
    }
}
