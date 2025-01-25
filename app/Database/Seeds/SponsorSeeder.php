<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SponsorSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('Sponsor')->insert([
            'event_id' => 1,
            'url' => 'https://www.jetbrains.com/',
            'logo' => 'images/coder2k.jpg',
            'logo_mime_type' => 'image/jpeg',
            'name' => 'JetBrains',
            'alt_text' => 'Das Logo von JetBrains',
            'copyright' => 'Copyright © 2000-2024 JetBrains s.r.o. JetBrains and the JetBrains logo are registered trademarks of JetBrains s.r.o.',
            'visible_from' => '2024-10-09 15:39:30',
            'created_at' => '2024-10-09 15:39:30',
        ]);
        $this->db->table('Sponsor')->insert([
            'event_id' => 1,
            'url' => 'https://de.weareholy.com/',
            'logo' => 'images/coder2k.jpg',
            'logo_mime_type' => 'image/jpeg',
            'name' => 'HOLY',
            'alt_text' => 'Das Logo von HOLY',
            'visible_from' => '2024-10-09 15:39:30',
            'created_at' => '2024-10-09 15:39:30',
        ]);
    }
}
