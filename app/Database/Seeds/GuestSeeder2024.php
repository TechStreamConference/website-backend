<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GuestSeeder2024 extends Seeder
{
    public function run()
    {

        $this->db->table('Guest')->insert([
            'talk_id' => 5, // Talk: Zwischen Code und Karriere: Soziale Dynamiken und der Übergang zum Beruf
            'user_id' => 2, // Limquats
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Guest')->insert([
            'talk_id' => 5, // Talk: Zwischen Code und Karriere: Soziale Dynamiken und der Übergang zum Beruf
            'user_id' => 12, // JHKrueger
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Guest')->insert([
            'talk_id' => 5, // Talk: Zwischen Code und Karriere: Soziale Dynamiken und der Übergang zum Beruf
            'user_id' => 9, // chrisfigge
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Guest')->insert([
            'talk_id' => 5, // Talk: Zwischen Code und Karriere: Soziale Dynamiken und der Übergang zum Beruf
            'user_id' => 10, // anywaygame
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Guest')->insert([
            'talk_id' => 15, // Talk: Von Code bis Community: Game Development, Softwareentwicklung und die Welt der Hackerspaces
            'user_id' => 16, // JvPeek
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Guest')->insert([
            'talk_id' => 15, // Talk: Von Code bis Community: Game Development, Softwareentwicklung und die Welt der Hackerspaces
            'user_id' => 8, // SculptyFix
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Guest')->insert([
            'talk_id' => 15, // Talk: Von Code bis Community: Game Development, Softwareentwicklung und die Welt der Hackerspaces
            'user_id' => 7, // Volker
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Guest')->insert([
            'talk_id' => 15, // Talk: Von Code bis Community: Game Development, Softwareentwicklung und die Welt der Hackerspaces
            'user_id' => 5, // Artimus83
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

    }
}
