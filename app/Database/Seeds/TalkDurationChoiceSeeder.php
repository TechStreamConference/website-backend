<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TalkDurationChoiceSeeder extends Seeder
{
    public function run()
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
    }
}
