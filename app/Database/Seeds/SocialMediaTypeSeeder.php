<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SocialMediaTypeSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('SocialMediaType')->insert([
            'name' => 'Twitch',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->table('SocialMediaType')->insert([
            'name' => 'Instagram',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->table('SocialMediaType')->insert([
            'name' => 'GitHub',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->table('SocialMediaType')->insert([
            'name' => 'Facebook',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
