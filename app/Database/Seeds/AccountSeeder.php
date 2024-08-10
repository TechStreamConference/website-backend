<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('Account')->insert(
            [
                'id' => null,
                'user_id' => 1,
                'email' => 'coder2k@test-conf.de',
                'username' => 'coder2k',
                'password' => password_hash('password', null),
            ]
        );
    }
}
