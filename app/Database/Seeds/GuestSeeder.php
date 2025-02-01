<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GuestSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('Guest')->insert([
            'talk_id' => 3,
            'user_id' => 4,
            'created_at' => '2025-02-01 12:15:44',
            'updated_at' => '2025-02-01 12:15:44',
        ]);
        // This will add coder2k as a guest to a talk where he is already the speaker, so this is
        // not a valid use case. But it is just for testing purposes.
        $this->db->table('Guest')->insert([
            'talk_id' => 3,
            'user_id' => 1,
            'created_at' => '2025-02-01 12:15:44',
            'updated_at' => '2025-02-01 12:15:44',
        ]);
    }
}
