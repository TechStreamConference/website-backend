<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TalkHasTagSeeder extends Seeder
{
    public function run()
    {
        // Katzen würden VISCA senden
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 2,
            'tag_id' => 1, // Maker
        ]);
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 2,
            'tag_id' => 2, // Reverse Engineering
        ]);
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 2,
            'tag_id' => 3, // Hacking
        ]);

        // Journey eines Rollenspiels. Wie wir angefangen und was wir gelernt haben.
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 1,
            'tag_id' => 4,
        ]);

        // In Farbe und Bunt I - Wie werden Farben im Computer gemacht
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 3,
            'tag_id' => 5,
        ]);
    }
}
