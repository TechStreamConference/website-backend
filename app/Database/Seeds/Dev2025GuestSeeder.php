<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Dev2025GuestSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('Guest')->insert([
            'talk_id' => 12,
            'user_id' => 10,
            'created_at' => '2025-02-01 12:15:44',
            'updated_at' => '2025-02-01 12:15:44',
        ]);

        $this->db->table('Guest')->insert([
            'talk_id' => 12,
            'user_id' => 11,
            'created_at' => '2025-02-01 12:15:44',
            'updated_at' => '2025-02-01 12:15:44',
        ]);

        $this->db->table('Guest')->insert([
            'talk_id' => 12,
            'user_id' => 12,
            'created_at' => '2025-02-01 12:15:44',
            'updated_at' => '2025-02-01 12:15:44',
        ]);

        $this->db->table('Guest')->insert([
            'talk_id' => 16,
            'user_id' => 13,
            'created_at' => '2025-02-01 12:15:44',
            'updated_at' => '2025-02-01 12:15:44',
        ]);

        $this->db->table('Guest')->insert([
            'talk_id' => 16,
            'user_id' => 14,
            'created_at' => '2025-02-01 12:15:44',
            'updated_at' => '2025-02-01 12:15:44',
        ]);

        $this->db->table('Guest')->insert([
            'talk_id' => 16,
            'user_id' => 15,
            'created_at' => '2025-02-01 12:15:44',
            'updated_at' => '2025-02-01 12:15:44',
        ]);
    }
}
