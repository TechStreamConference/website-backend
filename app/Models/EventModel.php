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
        'trailer_youtube_id',
        'description_headline',
        'description',
        'publish_date',
    ];
    protected $useTimestamps = true;
    protected array $casts = [
        'id' => 'int',
    ];

    public function get(int $eventId): array|null
    {
        return $this
            ->select('id, title, subtitle, start_date, end_date, discord_url, twitch_url, presskit_url, trailer_youtube_id, description_headline, description, publish_date')
            ->where('id', $eventId)
            ->first();
    }

    public function getPublished(int $eventId): array|null
    {
        return $this
            ->select('id, title, subtitle, start_date, end_date, discord_url, twitch_url, presskit_url, trailer_youtube_id, description_headline, description')
            ->where('id', $eventId)
            ->where('publish_date <=', date('Y-m-d H:i:s'))
            ->first();
    }

    public function getPublishedByYear(int $year): array|null
    {
        return $this
            ->select('id, title, subtitle, start_date, end_date, discord_url, twitch_url, presskit_url, trailer_youtube_id, description_headline, description')
            ->where('YEAR(start_date)', $year)
            ->where('publish_date <=', date('Y-m-d H:i:s'))
            ->first();
    }

    public function getAll(): array
    {
        return $this
            ->select('id, title, subtitle, start_date, end_date, discord_url, twitch_url, presskit_url, trailer_youtube_id, description_headline, description, publish_date')
            ->orderBy('start_date', 'DESC')
            ->findAll();
    }

    public function getAllPublished(): array
    {
        return $this
            ->select('id, title, subtitle, start_date, end_date, discord_url, twitch_url, presskit_url, trailer_youtube_id, description_headline, description')
            ->where('publish_date <=', date('Y-m-d H:i:s'))
            ->orderBy('start_date', 'DESC')
            ->findAll();
    }

    public function getLatestPublished(): array|null
    {
        return $this
            ->select('id, title, subtitle, start_date, end_date, discord_url, twitch_url, presskit_url, trailer_youtube_id, description_headline, description')
            ->where('publish_date <=', date('Y-m-d H:i:s'))
            ->orderBy('start_date', 'DESC')
            ->first();
    }

    public function updateEvent(
        int     $eventId,
        string  $title,
        string  $subtitle,
        string  $startDate,
        string  $endDate,
        ?string $discordUrl,
        ?string $twitchUrl,
        ?string $presskitUrl,
        ?string $trailerYoutubeId,
        string  $descriptionHeadline,
        string  $description,
        ?string $scheduleVisibleFrom,
        ?string $publishDate
    )
    {
        $this
            ->where('id', $eventId)
            ->set([
                'title' => $title,
                'subtitle' => $subtitle,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'discord_url' => $discordUrl,
                'twitch_url' => $twitchUrl,
                'presskit_url' => $presskitUrl,
                'trailer_youtube_id' => $trailerYoutubeId,
                'description_headline' => $descriptionHeadline,
                'description' => $description,
                'schedule_visible_from' => $scheduleVisibleFrom,
                'publish_date' => $publishDate,
            ])
            ->update();
    }

    public function createEvent(
        string  $title,
        string  $subtitle,
        string  $startDate,
        string  $endDate,
        ?string $discordUrl,
        ?string $twitchUrl,
        ?string $presskitUrl,
        ?string $trailerYoutubeId,
        string  $descriptionHeadline,
        string  $description,
        ?string $scheduleVisibleFrom,
        ?string $publishDate
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
            'trailer_youtube_id' => $trailerYoutubeId,
            'description_headline' => $descriptionHeadline,
            'description' => $description,
            'schedule_visible_from' => $scheduleVisibleFrom,
            'publish_date' => $publishDate,
        ]);
    }
}
