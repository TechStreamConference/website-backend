<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MediaPartnerSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('MediaPartner')->insert([
            'event_id' => 1,
            'url' => 'https://manasoup.com/',
            'logo' => 'images/coder2k.jpg',
            'logo_mime_type' => 'image/jpeg',
            'name' => 'ManaSoup',
            'alt_text' => 'Das Logo von ManaSoup',
            'visible_from' => '2024-10-09 15:39:30',
            'created_at' => '2024-10-09 15:39:30',
        ]);
        $this->db->table('MediaPartner')->insert([
            'event_id' => 1,
            'url' => 'https://indiehub.de/',
            'logo' => 'images/coder2k.jpg',
            'logo_mime_type' => 'image/jpeg',
            'name' => 'IndieHub',
            'alt_text' => 'Das Logo von IndieHub',
            'visible_from' => '2024-10-09 15:39:30',
            'created_at' => '2024-10-09 15:39:30',
        ]);
    }
}
