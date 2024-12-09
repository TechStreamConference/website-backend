<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SocialMediaTypeSeeder extends Seeder
{
    public function run()
    {
        $names = [
            'Web',
            'Twitch',
            'Discord',
            'LinkedIn',
            'YouTube',
            'Instagram',
            'X',
            'Git',
            'GitHub',
            'GitLab',
            'Mail',
        ];

        foreach ($names as $name) {
            $this->db->table('SocialMediaType')->insert([
                'name' => $name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
