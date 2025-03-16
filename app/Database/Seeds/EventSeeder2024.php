<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EventSeeder2024 extends Seeder
{
    public function run(): void
    {
        $this->db->table('Event')->insert(
            [
                'title' => 'Tech Stream Conference 2024',
                'subtitle' => 'Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.',
                'start_date' => '2024-06-22',
                'end_date' => '2024-06-23',
                'discord_url' => 'https://discord.com/invite/tp4EnphfKb',
                'twitch_url' => 'https://www.twitch.tv/coder2k',
                'presskit_url' => 'https://test-conf.de/Test-Conf-Presskit.zip',
                'publish_date' => '2024-01-01 12:00:00',
                'schedule_visible_from' => '2024-06-10 12:00:00',
                'trailer_youtube_id' => 'IW1vQAB6B18',
                'description_headline' => 'Sei dabei!',
                'description' => 'Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.
Wir möchten dich herzlich einladen, an unserer ersten Online-Konferenz teilzunehmen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch "special guests" und Überraschungen. Also sei gespannt!',
                'call_for_papers_start' => '2023-12-01 12:00:00',
                'call_for_papers_end' => '2023-12-02 12:00:00',
            ]
        );
    }
}
