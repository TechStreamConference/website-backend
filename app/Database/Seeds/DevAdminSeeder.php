<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DevAdminSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('Admin')->insert([
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
