<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('Tag')->insert([
            'text' => 'Maker',
            'color_index' => 1,
            'created_at' => '2024-10-10 19:19:55',
        ]);
        $this->db->table('Tag')->insert([
            'text' => 'Reverse Engineering',
            'color_index' => 2,
            'created_at' => '2024-10-10 19:19:55',
        ]);
        $this->db->table('Tag')->insert([
            'text' => 'Hacking',
            'color_index' => 2,
            'created_at' => '2024-10-10 19:19:55',
        ]);
        $this->db->table('Tag')->insert([
            'text' => 'Spieleentwicklung',
            'color_index' => 3,
            'created_at' => '2024-10-10 19:19:55',
        ]);
        $this->db->table('Tag')->insert([
            'text' => 'Programmierung',
            'color_index' => 4,
            'created_at' => '2024-10-10 19:19:55',
        ]);
    }
}
