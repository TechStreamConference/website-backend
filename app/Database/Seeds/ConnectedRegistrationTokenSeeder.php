<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ConnectedRegistrationTokenSeeder extends Seeder
{
    public function run(): void
    {
        // Token for a connected registration for the user that corresponds
        // to speaker "codingPurpurTentakel".
        $this->db->table('ConnectedRegistrationToken')->insert([
            'token' => 'd9f05f981302c5d8dcdd165cbd6b627ed33677207614e6fd6a1e9a68def5b6fd4180332e00475421e3bb7b6810bb2d1e6b6fa592cd613bee1b215b304a8a7b1a',
            'user_id' => 4,
        ]);
    }
}
