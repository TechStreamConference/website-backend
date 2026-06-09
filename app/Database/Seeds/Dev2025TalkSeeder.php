<?php

namespace App\Database\Seeds;
include_once "DevBioEntry.php";

use CodeIgniter\Database\Seeder;

class Dev2025TalkSeeder extends Seeder
{
    public function run(): void
    {
        // Day 1.
        // ID 11
        $this->db->table('Talk')->insert([
            'event_id' => 2,
            'user_id' => 1,
            'title' => '2. Talk eines Admins über die Leiden der User',
            'description' => get_bio_text(30),
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 11,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
            'youtube_url' => 'https://www.youtube.com',
        ]);
        // ID 12
        $this->db->table('Talk')->insert([
            'event_id' => 2,
            'user_id' => 2,
            'title' => '2. Talk eines Speakers über die Leiden der Test-Conf Seite',
            'description' => get_bio_text(200),
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 12,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
            'youtube_url' => 'https://www.youtube.com',
        ]);
        // ID 13
        $this->db->table('Talk')->insert([
            'event_id' => 2,
            'user_id' => 29,
            'title' => '2. Ich berichte darüber, wie man ohne Social Media Links leben kann',
            'description' => get_bio_text(100),
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 13,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
            'youtube_url' => 'https://www.youtube.com',
        ]);

        // Special talks day 1.
        // ID 14
        $this->db->table('Talk')->insert([
            'event_id' => 2,
            'user_id' => 21,
            'title' => '2. Der Mythos „Diamond Problem“',
            'description' => get_bio_text(10) . 'Auch wenn es um Mehrfachvererbung geht, ist es nicht nur OOP. C++ ist eine Multiparadigmen-Sprache und auch hier verbinden wir Möglichkeiten der verschiedenen Paradigmen zu Lösungen.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 14,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
            'youtube_url' => 'https://www.youtube.com',
        ]);

        // Day 2.
        // ID 15
        $this->db->table('Talk')->insert([
            'event_id' => 2,
            'user_id' => 22,
            'title' => '2. Sei nicht wie RockStar Games – lerne parsen in O(N)',
            'description' => get_bio_text(20) . 'In diesem Talk geht es darum, effizient strukturierte Daten aus Textdateien zu holen – und zwar mit Werkzeugen, die älter sind als der durchschnittliche Zuschauer.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 15,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
            'youtube_url' => 'https://www.youtube.com',
        ]);
        // ID 16
        $this->db->table('Talk')->insert([
            'event_id' => 2,
            'user_id' => 23,
            'title' => '2. Webentwicklung mit Symfony und Vue.js',
            'description' => 'Wie man mit Symfony in der Webentwicklung startet und worauf man achten sollte.' . get_bio_text(400),
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 16,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
            'youtube_url' => 'https://www.youtube.com',
        ]);
        // ID 17
        $this->db->table('Talk')->insert([
            'event_id' => 2,
            'user_id' => 6,
            'title' => '2. Ressourcenverwaltung unter C++',
            'description' => get_bio_text(15) . 'In diesem Talk geht es darum, wie man in C++ Ressourcensicherheit erreicht.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 17,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
            'youtube_url' => 'https://www.youtube.com',
        ]);

        // ID 18
        $this->db->table('Talk')->insert([
            'event_id' => 2,
            'user_id' => 7,
            'title' => '2. Wie man eine Konferenz organisiert',
            'description' => get_bio_text(25) . 'Das wissen wir selbst noch nicht so ganz genau Kappa',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 18,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
            'youtube_url' => 'https://www.youtube.com',
        ]);

        // ID 19
        $this->db->table('Talk')->insert([
            'event_id' => 2,
            'user_id' => 8,
            'title' => '2. Ein Talk zu einem fantastischen Thema',
            'description' => get_bio_text(5) . 'Richtig gutes Zeug!',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 19,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
            'youtube_url' => 'https://www.youtube.com',
        ]);

        // Special talks day 2.
        // ID 20
        $this->db->table('Talk')->insert([
            'event_id' => 2,
            'user_id' => 9,
            'title' => '2. Wie ist es eigentlich als letzter vorzutragen?',
            'description' => get_bio_text(120),
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 20,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
            'youtube_url' => 'https://www.youtube.com',
        ]);
    }
}
