<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DevAccountSeeder extends Seeder
{
    public function run(): void
    {
        // admin
        $this->db->table('Account')->insert(
            [
                'user_id' => 1,
                'email' => 'admin@test-conf.de',
                'username' => 'Admin',
                'is_verified' => true,
                'password' => password_hash('admin', null),
                'created_at' => date('2024-08-17 13:00:00'),
                'updated_at' => date('2024-08-17 13:00:00'),
            ]
        );

        // speaker
        $this->db->table('Account')->insert(
            [
                'user_id' => 2,
                'email' => 'speaker@test-conf.de',
                'username' => 'Speaker',
                'is_verified' => true,
                'password' => password_hash('speaker', null),
                'created_at' => date('2024-08-17 14:00:00'),
                'updated_at' => date('2024-08-17 14:00:00'),
            ]
        );
        // team member
        $this->db->table('Account')->insert(
            [
                'user_id' => 3,
                'email' => 'team-member@test-conf.de',
                'username' => 'TeamMember',
                'is_verified' => true,
                'password' => password_hash('teammember', null),
                'created_at' => date('2024-08-17 16:00:00'),
                'updated_at' => date('2024-08-17 16:00:00'),
            ]
        );

        // user
        $this->db->table('Account')->insert(
            [
                'user_id' => 4,
                'email' => 'user@test-conf.de',
                'username' => 'User',
                'is_verified' => true,
                'password' => password_hash('user', null),
                'created_at' => date('2024-08-17 16:00:00'),
                'updated_at' => date('2024-08-17 16:00:00'),
            ]
        );

        // "connected token" (user_id 5) has no account
    }
}
