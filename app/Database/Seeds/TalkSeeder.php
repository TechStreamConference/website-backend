<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TalkSeeder extends Seeder
{
    public function run()
    {
        // first day
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 4,
            'title' => 'Journey eines Rollenspiels. Wie wir angefangen und was wir gelernt haben.',
            'description' => 'Wir erzählen über unsere Erfahrungen und Erkenntnisse, von der Konzeption eines Open-World Rollenspiels, bis hin zu dessen Umsetzung.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 1,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Katzen würden VISCA senden',
            'description' => 'Ich habe ein Paket unaufgefordert bekommen. In den nächsten Monaten habe ich etwa 500 € ausgegeben, den Webshop eines Onlinehändlers leer gekauft und einen kleinen Trend losgetreten.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 2,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'In Farbe und Bunt I - Wie werden Farben im Computer gemacht',
            'description' => 'In diesem Lightning-Talk präsentiere ich eine kurze Zusammenfassung darüber, wie Farben in einem Computer repräsentiert und dargestellt werden.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 3,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);

        // second day
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 4,
            'title' => 'Der Mythos „Diamond Problem“',
            'description' => 'Auch wenn es um Mehrfachvererbung geht, ist es nicht nur OOP. C++ ist eine Multiparadigmen-Sprache und auch hier verbinden wir Möglichkeiten der verschiedenen Paradigmen zu Lösungen.',
            'is_special' => true,
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 4,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Sei nicht wie RockStar Games – lerne parsen in O(N)',
            'description' => 'In diesem Talk geht es darum, effizient strukturierte Daten aus Textdateien zu holen – und zwar mit Werkzeugen, die älter sind als der durchschnittliche Zuschauer.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 5,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Webentwicklung mit Symfony und Vue.js',
            'description' => 'Wie man mit Symfony in der Webentwicklung startet und worauf man achten sollte.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 6,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);

        // special talks
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Ressourcenverwaltung unter C++',
            'description' => 'In diesem Talk geht es darum, wie man in C++ Ressourcensicherheit erreicht.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 7,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Wie man eine Konferenz organisiert',
            'description' => 'Das wissen wir selbst noch nicht so ganz genau Kappa',
            'is_special' => true,
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 8,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);

        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Ein Talk zu einem fantastischen Thema',
            'description' => 'Richtig gutes Zeug!',
            'is_special' => true,
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 9,
            'time_slot_accepted' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
    }
}
