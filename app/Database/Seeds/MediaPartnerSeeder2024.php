<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MediaPartnerSeeder2024 extends Seeder
{
    public function run(): void
    {
        $this->db->table('MediaPartner')->insert([
            'event_id' => 1,
            'url' => 'https://discord.com/invite/KycxDwR',
            'logo' => 'indie_developer_stammtisch.png',
            'logo_mime_type' => 'image/png',
            'name' => 'Indie Developer Stammtisch',
            'alt_text' => 'Indie Developer Stammtisch',
            'visible_from' => '2024-01-01 00:00:00',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);
        $this->db->table('MediaPartner')->insert([
            'event_id' => 1,
            'url' => 'https://indiehub.de/',
            'logo' => 'indie_hub.png',
            'logo_mime_type' => 'image/png',
            'name' => 'Indie Hub',
            'alt_text' => 'Indie Hub Stammtisch',
            'visible_from' => '2024-01-01 00:00:00',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);
        $this->db->table('MediaPartner')->insert([
            'event_id' => 1,
            'url' => 'https://manasoup.com/',
            'logo' => 'manasoup_network.png',
            'logo_mime_type' => 'image/png',
            'name' => 'ManaSoup',
            'alt_text' => 'Das Logo von ManaSoup',
            'visible_from' => '2024-01-01 00:00:00',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);
        $this->db->table('MediaPartner')->insert([
            'event_id' => 1,
            'url' => 'https://www.devcom.global/',
            'logo' => 'devcom.webp',
            'logo_mime_type' => 'image/webp',
            'name' => 'devcom',
            'alt_text' => 'Das Logo von devcom',
            'visible_from' => '2024-01-01 00:00:00',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);
    }
}
