<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('Event')->insert(
            [
                'title' => 'Tech Stream Conference 2024',
                'subtitle' => 'Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.',
                'start_date' => date('2024-06-22'),
                'end_date' => date('2024-06-23'),
                'discord_url' => 'https://discord.com/invite/tp4EnphfKb',
                'twitch_url' => 'https://www.twitch.tv/coder2k',
                'presskit_url' => 'https://test-conf.de/Test-Conf-Presskit.zip',
                'publish_date' => date('2024-01-01 12:00:00'),
                'frontpage_date' => date('2024-01-01 12:00:00'),
                'schedule_visible_from' => date('2024-06-10 12:00:00'),
                'trailer_url' => 'https://www.youtube.com/watch?v=IW1vQAB6B18',
                'trailer_poster_url' => 'https://img.youtube.com/vi/IW1vQAB6B18/maxresdefault.jpg',
                'description_headline' => 'Sei dabei!',
                'description' => 'Spannende Vorträge aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung erwarten dich.
Wir möchten dich herzlich einladen, an unserer ersten Online-Konferenz teilzunehmen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch "special guests" und Überraschungen. Also sei gespannt!',
                'call_for_papers_start' => date('2023-12-01 12:00:00'),
                'call_for_papers_end' => date('2030-03-01 12:00:00'),
            ]
        );
        $this->db->table('Event')->insert(
            [
                'title' => 'Tech Stream Conference 2025',
                'subtitle' => 'Das Imperium schlägt zurück!',
                'start_date' => date('2025-06-22'),
                'end_date' => date('2025-06-23'),
                'discord_url' => 'https://discord.com/invite/tp4EnphfKb',
                'twitch_url' => 'https://www.twitch.tv/coder2k',
                'presskit_url' => 'https://test-conf.de/Test-Conf-Presskit.zip',
                'schedule_visible_from' => date('2025-06-22 12:00:00'),
                'trailer_url' => 'https://www.youtube.com/watch?v=IW1vQAB6B18',
                'trailer_poster_url' => 'https://img.youtube.com/vi/IW1vQAB6B18/maxresdefault.jpg',
                'description_headline' => 'Komm\' ran!',
                'description' => 'In einer weit, weit entfernten Galaxis...
Die Tech Stream Conference 2025 steht unter dem Motto "Das Imperium schlägt zurück!".
Sei dabei, wenn wir die dunkle Seite der Macht beleuchten und uns mit den dunklen Machenschaften der Technik beschäftigen. Freu dich auf unterhaltsame und interessante Vorträge – von der Community für die Community. Die Vortragenden stammen aus der Technik-Bubble von Twitch. Dazu gibt es noch "special guests" und Überraschungen.
Also sei gespannt!',
            ]
        );
    }
}
