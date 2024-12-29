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
                'is_verified' => true,
                'password' => password_hash('password', null),
                'created_at' => date('2024-08-17 13:00:00'),
                'updated_at' => date('2024-08-17 13:00:00'),
            ]
        );
        $this->db->table('Account')->insert(
            [
                'user_id' => 2,
                'email' => 'gyrosgeier@geier.horst',
                'username' => 'Gyros Geier',
                'is_verified' => true,
                'password' => password_hash('horst', null),
                'created_at' => date('2024-08-17 14:00:00'),
                'updated_at' => date('2024-08-17 14:00:00'),
            ]
        );
        $this->db->table('Account')->insert(
            [
                'user_id' => 5,
                'email' => 'claus@kleber.de',
                'username' => 'ClausKleber',
                'is_verified' => true,
                'password' => password_hash('ClausKleber123!', null),
                'created_at' => date('2024-08-17 16:00:00'),
                'updated_at' => date('2024-08-17 16:00:00'),
            ]
        );
    }
}
