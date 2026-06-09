<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Dev2024MediaPartnerSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('MediaPartner')->insert([
            'event_id' => 1,
            'url' => 'https://manasoup.com/',
            'logo' => 'media_partner_1.png',
            'logo_mime_type' => 'image/png',
            'logo_alternative' => 'media_partner_1_dark.png',
            'logo_alternative_mime_type' => 'image/png',
            'name' => 'Space Horizon',
            'alt_text' => 'Das Logo von Space Horizon',
            'visible_from' => '2024-10-09 15:39:30',
            'created_at' => '2024-10-09 15:39:30',
        ]);
        $this->db->table('MediaPartner')->insert([
            'event_id' => 1,
            'url' => 'https://indiehub.de/',
            'logo' => 'media_partner_2.jpg',
            'logo_mime_type' => 'image/png',
            'logo_alternative' => 'media_partner_2_dark.png',
            'logo_alternative_mime_type' => 'image/png',
            'name' => 'Cosmos',
            'alt_text' => 'Das Logo von Cosmos',
            'visible_from' => '2024-10-09 15:39:30',
            'created_at' => '2024-10-09 15:39:30',
        ]);
    }
}
