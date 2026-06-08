<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DevUserSeeder extends Seeder
{
    public function run(): void
    {
        // account "admin"
        // account "speaker"
        // account "team-member"
        // account "user"
        // "connected-token" this user can be connected with a token
        foreach (range(1, 5) as $userId){
            $this->db->table('User')->insert([
                'id' => $userId,
                'created_at' => date('1985-10-21 07:28:00'),
                'updated_at' => date('1985-10-21 07:28:00'),
            ]);
        }

        // "generic-speaker-1" - "generic-speaker-10"
        foreach (range(6, 15) as $userId) {
            $this->db->table('User')->insert([
                'id' => $userId,
                'created_at' => date('1985-10-21 07:28:00'),
                'updated_at' => date('1985-10-21 07:28:00'),
            ]);
        }

        // "generic-team-member-1" - "generic-team-member-5"
        foreach (range(16, 20) as $userId) {
            $this->db->table('User')->insert([
                'id' => $userId,
                'created_at' => date('1985-10-21 07:28:00'),
                'updated_at' => date('1985-10-21 07:28:00'),
            ]);
        }

        // "generic-event-1-speaker", 21-23
        // "generic-event-2-speaker", 24-26
        // "generic-event-1-team-member", 27
        // "generic-event-2-team-member" 28
        foreach (range(21, 28) as $userId) {
            $this->db->table('User')->insert([
                'id' => $userId,
                'created_at' => date('1985-10-21 07:28:00'),
                'updated_at' => date('1985-10-21 07:28:00'),
            ]);
        }

        // "no-social-media-links"
        $this->db->table('User')->insert([
            'id' => 29,
            'created_at' => date('1985-10-21 07:28:00'),
            'updated_at' => date('1985-10-21 07:28:00'),
        ]);
    }
}

