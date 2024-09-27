<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SocialMediaLinkSeeder extends Seeder
{
    public function run()
    {
        $date_format_string = 'Y-m-d H:i:s';

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Twitch
            'speaker_id' => 2, // coder2k
            'url' => 'https://www.twitch.tv/coder2k',
            'created_at' => date($date_format_string),
            'updated_at' => date($date_format_string),
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // GitHub
            'speaker_id' => 2, // coder2k
            'url' => 'https://www.github.com/mgerhold',
            'created_at' => date($date_format_string),
            'updated_at' => date($date_format_string),
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Twitch
            'speaker_id' => 5, // codingPurpurTentakel
            'url' => 'https://www.twitch.tv/codingPurpurTentakel',
            'created_at' => date($date_format_string),
            'updated_at' => date($date_format_string),
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Twitch
            'speaker_id' => 5, // codingPurpurTentakel
            'url' => 'https://www.twitch.tv/codingPurpurTentakelSecondChannel',
            'created_at' => date($date_format_string),
            'updated_at' => date($date_format_string),
        ]);
    }
}
