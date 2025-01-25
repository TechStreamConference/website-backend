<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SocialMediaLinkSeeder extends Seeder
{
    public function run(): void
    {
        $date_format_string = 'Y-m-d H:i:s';

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 1, // coder2k
            'url' => 'https://www.twitch.tv/coder2k',
            'approved' => true,
            'created_at' => date($date_format_string),
            'updated_at' => date($date_format_string),
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 1, // coder2k
            'url' => 'https://www.github.com/mgerhold',
            'approved' => false,
            'created_at' => date($date_format_string),
            'updated_at' => date($date_format_string),
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 4, // codingPurpurTentakel
            'url' => 'https://www.twitch.tv/codingPurpurTentakel',
            'approved' => true,
            'created_at' => date($date_format_string),
            'updated_at' => date($date_format_string),
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 4, // codingPurpurTentakel
            'url' => 'https://www.twitch.tv/codingPurpurTentakelSecondChannel',
            'approved' => true,
            'created_at' => date($date_format_string),
            'updated_at' => date($date_format_string),
        ]);
    }
}
