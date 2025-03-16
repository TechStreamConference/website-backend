<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SocialMediaTypeSeeder2024 extends Seeder
{
    public function run(): void
    {

        $this->db->table('SocialMediaType')->insert([
            'id' => 1,
            'name' => 'Web',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaType')->insert([
            'id' => 2,
            'name' => 'Twitch',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaType')->insert([
            'id' => 3,
            'name' => 'Discord',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaType')->insert([
            'id' => 4,
            'name' => 'LinkedIn',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaType')->insert([
            'id' => 5,
            'name' => 'YouTube',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaType')->insert([
            'id' => 6,
            'name' => 'Instagram',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaType')->insert([
            'id' => 7,
            'name' => 'X',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaType')->insert([
            'id' => 8,
            'name' => 'Git',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaType')->insert([
            'id' => 9,
            'name' => 'GitHub',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaType')->insert([
            'id' => 10,
            'name' => 'GitLab',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaType')->insert([
            'id' => 11,
            'name' => 'Facebook',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

    }
}
