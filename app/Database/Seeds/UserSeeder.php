<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('User')->insert([
            'id' => null,
            'created_at' => date('1985-10-21 07:28:00'),
            'updated_at' => date('1985-10-21 07:28:00'),
        ]);
        $this->db->table('User')->insert([
            'id' => null,
            'created_at' => date('2024-08-17 13:39:35'),
            'updated_at' => date('2024-08-17 13:39:35'),
        ]);
    }
}
