<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('Account')->insert(
            [
                'user_id' => 1,
                'email' => 'coder2k@test-conf.de',
                'username' => 'coder2k',
                'password' => password_hash('password', null),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
    }
}
