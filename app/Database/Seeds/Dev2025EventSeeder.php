<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Dev2025EventSeeder extends Seeder
{
    public function run(): void
    {
        // ID 2
        $this->db->table('Event')->insert(
            [
                'title' => 'Tech Stream Conference 2025',
                'subtitle' => 'Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.',
                'start_date' => date('2025-07-03'),
                'end_date' => date('2025-07-04'),
                'discord_url' => 'https://discord.com/invite/tp4EnphfKb',
                'twitch_url' => 'https://www.twitch.tv/coder2k',
                'presskit_url' => 'https://test-conf.de/Test-Conf-Presskit.zip',
                'publish_date' => date('2025-01-01 12:00:00'),
                'frontpage_date' => date('2025-01-01 12:00:00'),
                'schedule_visible_from' => date('2025-06-10 12:00:00'),
                'trailer_url' => null,
                'trailer_poster_url' => null,
                'trailer_subtitles_url' => null,
                'description_headline' => 'Sei dabei!',
                'description' => 'Die Tech-Bubble von Twitch kommt erneut zusammen: Zum 2. Mal treffen sich Programmierung, Maker-Szene und Spieleentwicklung – praxisnah, unterhaltsam, aus der Community für die Community. Freu dich auf Talks, Diskussionsrunden, Lightning-Talks, Special Guests und die ein oder andere Überraschung. Sei live mit dabei – online und kostenlos!',
                'call_for_papers_start' => date('2024-12-01 12:00:00'),
                'call_for_papers_end' => date('2025-03-01 12:00:00'),
            ]
        );
    }
}
