<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder2024 extends Seeder
{
    public function run()
    {

        $this->db->table('Admin')->insert([
            'user_id' => 18,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Admin')->insert([
            'user_id' => 25,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

    }
}
