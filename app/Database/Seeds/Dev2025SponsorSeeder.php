<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Dev2025SponsorSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('Sponsor')->insert([
            'event_id' => 2,
            'url' => 'https://de.weareholy.com/',
            'logo' => 'sponsor_gif.gif',
            'logo_mime_type' => 'image/gif',
            'name' => 'HOLY',
            'alt_text' => 'Das Logo von HOLY',
            'visible_from' => '2024-10-09 15:39:30',
            'created_at' => '2024-10-09 15:39:30',
        ]);
        $this->db->table('Sponsor')->insert([
            'event_id' => 2,
            'url' => 'https://de.weareholy.com/',
            'logo' => 'sponsor_2.png',
            'logo_mime_type' => 'image/png',
            'logo_alternative' => 'sponsor_2_dark.png',
            'logo_alternative_mime_type' => 'image/png',
            'name' => 'Oreon',
            'alt_text' => 'Das Logo von Oreon',
            'visible_from' => '2024-10-09 15:39:30',
            'created_at' => '2024-10-09 15:39:30',
        ]);
        $this->db->table('Sponsor')->insert([
            'event_id' => 2,
            'url' => 'https://www.jetbrains.com/',
            'logo' => 'sponsor_1.png',
            'logo_mime_type' => 'image/png',
            'logo_alternative' => 'sponsor_1_dark.png',
            'logo_alternative_mime_type' => 'image/png',
            'name' => 'Astra',
            'alt_text' => 'Das Logo von Astra',
            'copyright' => 'Copyright © 2000-2024 JetBrains s.r.o. JetBrains and the JetBrains logo are registered trademarks of JetBrains s.r.o.',
            'visible_from' => '2024-10-09 15:39:30',
            'created_at' => '2024-10-09 15:39:30',
        ]);
    }
}
