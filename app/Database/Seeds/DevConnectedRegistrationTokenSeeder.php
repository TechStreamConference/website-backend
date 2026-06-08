<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DevConnectedRegistrationTokenSeeder extends Seeder
{
    public function run(): void
    {
        // "connected token"
        $this->db->table('ConnectedRegistrationToken')->insert([
            'token' => '123456',
            'user_id' => 5,
        ]);
    }
}
