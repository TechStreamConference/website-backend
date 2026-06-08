<?php

namespace App\Database\Seeds;
include_once "DevBioEntry.php";

use CodeIgniter\Database\Seeder;

class Dev2024TalkSeeder extends Seeder
{
    public function run(): void
    {
        // Day 1.
        // ID 1
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Talk eines Admins über die Leiden der User',
            'description' => get_bio_text(50),
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 1,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        // ID 2
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 2,
            'title' => 'Talk eines Speakers über die Leiden der Test-Conf Seite',
            'description' => get_bio_text(400),
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 2,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        // ID 3
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 29,
            'title' => 'Ich berichte darüber, wie man ohne Social Media Links leben kann',
            'description' => get_bio_text(75),
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 3,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);

        // Special talks day 1.
        // ID 4
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 21,
            'title' => 'Der Mythos „Diamond Problem“',
            'description' => 'Auch wenn es um Mehrfachvererbung geht, ist es nicht nur OOP. C++ ist eine Multiparadigmen-Sprache und auch hier verbinden wir Möglichkeiten der verschiedenen Paradigmen zu Lösungen.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 4,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);

        // Day 2.
        // ID 5
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 22,
            'title' => 'Sei nicht wie RockStar Games – lerne parsen in O(N)',
            'description' => 'In diesem Talk geht es darum, effizient strukturierte Daten aus Textdateien zu holen – und zwar mit Werkzeugen, die älter sind als der durchschnittliche Zuschauer.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 5,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        // ID 6
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 23,
            'title' => 'Webentwicklung mit Symfony und Vue.js',
            'description' => 'Wie man mit Symfony in der Webentwicklung startet und worauf man achten sollte.' . get_bio_text(300),
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 6,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        // ID 7
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 6,
            'title' => 'Ressourcenverwaltung unter C++',
            'description' => 'In diesem Talk geht es darum, wie man in C++ Ressourcensicherheit erreicht.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 7,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);

        // Special talks day 2.
        // ID 8
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 7,
            'title' => 'Wie man eine Konferenz organisiert',
            'description' => 'Das wissen wir selbst noch nicht so ganz genau Kappa',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 8,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);

        // ID 9
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 8,
            'title' => 'Ein Talk zu einem fantastischen Thema',
            'description' => 'Richtig gutes Zeug!',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 9,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);

        // ID 10
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 9,
            'title' => 'Wie ist es eigentlich als letzter vorzutragen?',
            'description' => get_bio_text(100),
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 10,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
    }
}
