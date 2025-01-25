<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TalkHasTagSeeder extends Seeder
{
    public function run(): void
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

        // Der Mythos „Diamond Problem“
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 4,
            'tag_id' => 1, // Maker
        ]);
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 4,
            'tag_id' => 2, // Reverse Engineering
        ]);
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 4,
            'tag_id' => 3, // Hacking
        ]);

        // Sei nicht wie RockStar Games – lerne parsen in O(N)
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 5,
            'tag_id' => 4,
        ]);

        // Webentwicklung mit Symfony und Vue.js
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 6,
            'tag_id' => 5,
        ]);

        // Wie man eine Konferenz organisiert
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 7,
            'tag_id' => 1, // Maker
        ]);
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 7,
            'tag_id' => 2, // Reverse Engineering
        ]);
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 7,
            'tag_id' => 3, // Hacking
        ]);

        // Ressourcenverwaltung unter C++
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 8,
            'tag_id' => 4,
        ]);

        // Ein Talk zu einem fantastischen Thema
        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 9,
            'tag_id' => 1, // Maker
        ]);
    }
}
