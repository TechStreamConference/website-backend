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
            'starts_at' => '2024-06-22 14:00:00',
            'duration' => 45,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Katzen würden VISCA senden',
            'description' => 'Ich habe ein Paket unaufgefordert bekommen. In den nächsten Monaten habe ich etwa 500 € ausgegeben, den Webshop eines Onlinehändlers leer gekauft und einen kleinen Trend losgetreten.',
            'starts_at' => '2024-06-22 13:00:00',
            'duration' => 45,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'In Farbe und Bunt I - Wie werden Farben im Computer gemacht',
            'description' => 'In diesem Lightning-Talk präsentiere ich eine kurze Zusammenfassung darüber, wie Farben in einem Computer repräsentiert und dargestellt werden.',
            'starts_at' => '2024-06-22 15:00:00',
            'duration' => 15,
            'created_at' => '2024-03-10 19:19:55',
        ]);

        // second day
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 4,
            'title' => 'Der Mythos „Diamond Problem“',
            'description' => 'Auch wenn es um Mehrfachvererbung geht, ist es nicht nur OOP. C++ ist eine Multiparadigmen-Sprache und auch hier verbinden wir Möglichkeiten der verschiedenen Paradigmen zu Lösungen.',
            'starts_at' => '2024-06-23 11:00:00',
            'duration' => 45,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Sei nicht wie RockStar Games – lerne parsen in O(N)',
            'description' => 'In diesem Talk geht es darum, effizient strukturierte Daten aus Textdateien zu holen – und zwar mit Werkzeugen, die älter sind als der durchschnittliche Zuschauer.',
            'starts_at' => '2024-06-23 12:00:00',
            'duration' => 45,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Webentwicklung mit Symfony und Vue.js',
            'description' => 'Wie man mit Symfony in der Webentwicklung startet und worauf man achten sollte.',
            'starts_at' => '2024-06-23 13:00:00',
            'duration' => 15,
            'created_at' => '2024-03-10 19:19:55',
        ]);

        // special talks
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Ressourcenverwaltung unter C++',
            'description' => 'In diesem Talk geht es darum, wie man in C++ Ressourcensicherheit erreicht.',
            'starts_at' => '2024-06-23 19:30:00',
            'duration' => 45,
            'is_special' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Wie man eine Konferenz organisiert',
            'description' => 'Das wissen wir selbst noch nicht so ganz genau Kappa',
            'starts_at' => '2024-06-23 18:30:00',
            'duration' => 45,
            'is_special' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);

        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Ein Talk zu einem fantastischen Thema',
            'description' => 'Richtig gutes Zeug!',
            'starts_at' => '2024-06-22 19:30:00',
            'duration' => 45,
            'is_special' => true,
            'created_at' => '2024-03-10 19:19:55',
        ]);
    }
}
