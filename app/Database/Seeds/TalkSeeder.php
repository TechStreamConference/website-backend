<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TalkSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'speaker_id' => 5,
            'title' => 'Journey eines Rollenspiels. Wie wir angefangen und was wir gelernt haben.',
            'description' => 'Wir erzählen über unsere Erfahrungen und Erkenntnisse, von der Konzeption eines Open-World Rollenspiels, bis hin zu dessen Umsetzung.',
            'starts_at' => '2024-06-22 14:00:00',
            'duration' => 45,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'speaker_id' => 2,
            'title' => 'Katzen würden VISCA senden',
            'description' => 'Ich habe ein Paket unaufgefordert bekommen. In den nächsten Monaten habe ich etwa 500 € ausgegeben, den Webshop eines Onlinehändlers leer gekauft und einen kleinen Trend losgetreten.',
            'starts_at' => '2024-06-22 13:00:00',
            'duration' => 45,
            'created_at' => '2024-03-10 19:19:55',
        ]);
        $this->db->table('Talk')->insert([
            'event_id' => 1,
            'speaker_id' => 2,
            'title' => 'In Farbe und Bunt I - Wie werden Farben im Computer gemacht',
            'description' => 'In diesem Lightning-Talk präsentiere ich eine kurze Zusammenfassung darüber, wie Farben in einem Computer repräsentiert und dargestellt werden.',
            'starts_at' => '2024-06-22 15:00:00',
            'duration' => 15,
            'created_at' => '2024-03-10 19:19:55',
        ]);
    }
}
