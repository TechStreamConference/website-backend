<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SponsorSeeder2024 extends Seeder
{
    public function run(): void
    {
        $this->db->table('Sponsor')->insert([
            'event_id' => 1,
            'url' => 'https://www.jetbrains.com/',
            'logo' => 'jetbrains.png',
            'logo_mime_type' => 'image/png',
            'name' => 'JetBrains',
            'alt_text' => 'Das Logo von JetBrains',
            'copyright' => 'Copyright © 2000-2024 JetBrains s.r.o. JetBrains and the JetBrains logo are registered trademarks of JetBrains s.r.o.',
            'visible_from' => '2024-01-01 00:00:00',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);
        $this->db->table('Sponsor')->insert([
            'event_id' => 1,
            'url' => 'https://de.weareholy.com/',
            'logo' => 'holy.gif',
            'logo_mime_type' => 'image/gif',
            'name' => 'HOLY',
            'alt_text' => 'Das Logo von HOLY',
            'visible_from' => '2024-01-01 00:00:00',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);
        $this->db->table('Sponsor')->insert([
            'event_id' => 1,
            'url' => 'https://www.nobreakpoints.com/',
            'logo' => 'nobreakpoints.png',
            'logo_mime_type' => 'image/png',
            'name' => 'nobreakpoints',
            'alt_text' => 'Das Logo von nobreakpoints',
            'visible_from' => '2024-01-01 00:00:00',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);
    }
}
