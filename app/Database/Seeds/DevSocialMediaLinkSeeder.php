<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DevSocialMediaLinkSeeder extends Seeder
{
    public function run(): void
    {
        $date_format_string = 'Y-m-d H:i:s';

        // "admin"
        // "speaker"
        // "team-member"
        // "user"
        // "connected-token"
        foreach (range(1, 5) as $user_id) {
            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 1, // web
                'user_id' => $user_id,
                'url' => 'https://coder2k.net',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 2, // Twitch
                'user_id' => $user_id,
                'url' => 'https://www.twitch.tv/coder2k',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 3, // Discord
                'user_id' => $user_id,
                'url' => 'https://discord.gg/CtFebtPRJK',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 4, // LinkedIn
                'user_id' => $user_id,
                'url' => 'https://www.linkedin.com/in/michael-gerhold-b478b51b2/',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 6, // Instagram
                'user_id' => $user_id,
                'url' => 'https://www.instagram.com/coder2k/',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 9, // GitHub
                'user_id' => $user_id,
                'url' => 'https://github.com/mgerhold/',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);
        }

        // "generic-speaker-1" - "generic-speaker-10"
        foreach (range(6,15) as $user_id) {
            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 1, // web
                'user_id' => $user_id,
                'url' => 'https://google.de',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 2, // Twitch
                'user_id' => $user_id,
                'url' => 'https://twitch.tv',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 3, // Discord
                'user_id' => $user_id,
                'url' => 'https://discord.gg',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 4, // LinkedIn
                'user_id' => $user_id,
                'url' => 'https://linkedIn.com',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 5, // YouTube
                'user_id' => $user_id,
                'url' => 'https://youtube.de',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 6, // Instagram
                'user_id' => $user_id,
                'url' => 'https://instagram.de',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);
        }

        // "generic-team-member-1" - "generic-team-member-5"
        foreach (range(16, 20) as $user_id) {
            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 7, // X
                'user_id' => $user_id,
                'url' => 'https://X.com',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 8, // Git
                'user_id' => $user_id,
                'url' => 'https://google.de',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 9, // GitHub
                'user_id' => $user_id,
                'url' => 'https://github.com',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 10, // GitLab
                'user_id' => $user_id,
                'url' => 'https://gitlab.com',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 11, // Facebook
                'user_id' => $user_id,
                'url' => 'https://facebook.de',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);
        }

        // "generic-event-1-speaker",
        // "generic-event-2-speaker",
        // "generic-event-1-team-member",
        // "generic-event-2-team-member"
        foreach (range(21,28) as $user_id){
            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 1, // web
                'user_id' => $user_id,
                'url' => 'https://google.de',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 2, // Twitch
                'user_id' => $user_id,
                'url' => 'https://twitch.tv',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 3, // Discord
                'user_id' => $user_id,
                'url' => 'https://discord.gg',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 5, // YouTube
                'user_id' => $user_id,
                'url' => 'https://youtube.de',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 6, // Instagram
                'user_id' => $user_id,
                'url' => 'https://instagram.de',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);

            $this->db->table('SocialMediaLink')->insert([
                'social_media_type_id' => 9, // GitHub
                'user_id' => $user_id,
                'url' => 'https://github.com',
                'approved' => true,
                'created_at' => date($date_format_string),
                'updated_at' => date($date_format_string),
            ]);
        }

        // user-id 29 has no social media links
    }
}
