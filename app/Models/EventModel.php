<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'Event';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'subtitle',
        'start_date',
        'end_date',
        'discord_url',
        'twitch_url',
        'presskit_url',
        'trailer_url',
        'description_headline',
        'description',
    ];
    protected $useTimestamps = true;

    public function get(int $eventId): array|null
    {
        return $this->where('id', $eventId)->first();
    }

    public function getByYear(int $year): array|null
    {
        return $this->where('YEAR(start_date)', $year)->first();
    }

    public function create(
        string $title,
        string $subtitle,
        string $startDate,
        string $endDate,
        string $discordUrl,
        string $twitchUrl,
        string $presskitUrl,
        string $trailerUrl,
        string $descriptionHeadline,
        string $description,
    ): int
    {
        return $this->insert([
            'title' => $title,
            'subtitle' => $subtitle,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'discord_url' => $discordUrl,
            'twitch_url' => $twitchUrl,
            'presskit_url' => $presskitUrl,
            'trailer_url' => $trailerUrl,
            'description_headline' => $descriptionHeadline,
            'description' => $description,
        ]);
    }
}