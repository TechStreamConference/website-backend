<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TalkDurationChoiceSeeder2024 extends Seeder
{
    public function run(): void
    {

        $this->db->table('TalkDurationChoice')->insert([
            'duration' => 5,
        ]);

        $this->db->table('TalkDurationChoice')->insert([
            'duration' => 10,
        ]);

        $this->db->table('TalkDurationChoice')->insert([
            'duration' => 15,
        ]);

        $this->db->table('TalkDurationChoice')->insert([
            'duration' => 30,
        ]);

        $this->db->table('TalkDurationChoice')->insert([
            'duration' => 45,
        ]);

        $this->db->table('TalkDurationChoice')->insert([
            'duration' => 60,
        ]);

        $this->db->table('TalkDurationChoice')->insert([
            'duration' => 90,
        ]);

        $this->db->table('TalkDurationChoice')->insert([
            'duration' => 120,
        ]);

    }
}
