<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TeamMemberSeeder2024 extends Seeder
{
    public function run(): void
    {

        $this->db->table('TeamMember')->insert([
            'name' => 'LordRepha',
            'user_id' => 1,
            'event_id' => 1,
            'short_bio' => 'Test-Conf Wizard, Webentwickler, Softwareentwickler',
            'bio' => 'Mit über 15 Jahren Erfahrung in der Webentwicklung und mehr als einem Jahrzehnt im Gesundheitswesen verfüge ich über einen reichen Erfahrungsschatz. Mein Schwerpunkt liegt auf der Entwicklung von maßgeschneiderten Lösungen für das Gesundheitswesen sowie Portale und CRMs für Unternehmen. Ich besitze umfassenden Erfahrung im Einsatz von Vue.js, Node.js und MongoDB.',
            'photo' => 'lord_repha.jpg',
            'photo_mime_type' => 'image/jpeg',
            'is_approved' => true,
            'visible_from' => '2024-01-01 00:00:00',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('TeamMember')->insert([
            'name' => 'coder2k',
            'user_id' => 18,
            'event_id' => 1,
            'short_bio' => 'Test-Conf Host, Software-Entwickler, freier Dozent, Twitch-Partner',
            'bio' => 'Michael (coder2k) hat vor über 20 Jahren \'Turbo Pascal und Delphi für Kids\' gelesen und sich seitdem mit dem Programmieren in verschiedenen Programmiersprachen beschäftigt. Er ist tätig als Software-Entwickler im Embedded-Umfeld und freier Dozent. Seit drei Jahren programmiert er auch auf Twitch und ist seit Anfang 2024 Twitch-Partner. Michael ist es wichtig, Wissen mit anderen auszutauschen und sich dadurch gemeinsam weiterzuentwickeln und neue Dinge zu lernen – und daraus ist auch die Idee zur Test-Conf entstanden.',
            'photo' => 'coder2k.jpg',
            'photo_mime_type' => 'image/jpeg',
            'is_approved' => true,
            'visible_from' => '2024-01-01 00:00:00',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('TeamMember')->insert([
            'name' => 'CrazyNightowl01',
            'user_id' => 23,
            'event_id' => 1,
            'short_bio' => 'Test-Conf Mod, Freizeit-Webentwicklerin, Gamerin, Retro-Games-Fan',
            'bio' => 'Auf Twitch bin ich CrazyNightowl01, ihr dürft euch aber gerne einen Namen aussuchen. Von Eule, Euli, Nightowl, Owl, Owly war schon alles dabei. Auf Twitch bin ich meistens als Lurkerin unterwegs, aber auch in ein paar Coding-Kanälen als Mod.',
            'photo' => 'crazy_nightowl01.jpg',
            'photo_mime_type' => 'image/jpeg',
            'is_approved' => true,
            'visible_from' => '2024-01-01 00:00:00',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('TeamMember')->insert([
            'name' => 'NoodyDraws',
            'user_id' => 24,
            'event_id' => 1,
            'short_bio' => 'Test-Conf Artist, Animator, 2D Artist, Designer',
            'bio' => 'Noody ist eine freiberufliche 2D Artist, Grafikerin und Animatorin. Sie arbeitet hauptsächlich in der Videospielbranche und hat an Spielen wie \'Deponia\' oder \'Leisure Suit Larry: Wet Dreams Don\'t Dry\' gearbeitet. In ihrer Freizeit arbeitet sie an einem Japan Guide, eigenen Emotes für Twitch oder Illustrationen für ihre Patreons.',
            'photo' => 'noody_draws.jpg',
            'photo_mime_type' => 'image/jpeg',
            'is_approved' => true,
            'visible_from' => '2024-01-01 00:00:00',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('TeamMember')->insert([
            'name' => 'codingPurpurTentakel',
            'user_id' => 25,
            'event_id' => 1,
            'short_bio' => 'Test-Conf Host, Veranstaltungstechniker, Elektroniker, Hobby-Coder',
            'bio' => 'Martin (Purpur Tentakel) kommt aus Köln. Nach der Schule macht er eine Ausbildung zur Fachkraft für Veranstaltungstechnik. Durch Corona kann er nach der Ausbildung nicht in der Branche weiter arbeiten und macht eine 2. Ausbildung zum Elektroniker für Betriebstechnik. In der Zeit der 2. Ausblidung trifft er irgendwann mal auf den Kanal von coder2k. Tja nun muss er coden. Von Python über C# kommt er schließlich zu c++. Seither programmiert er an seinem Spiel \'Tentakels Attacking\'',
            'photo' => 'coding_purpur_tentakel.jpg',
            'photo_mime_type' => 'image/jpeg',
            'is_approved' => true,
            'visible_from' => '2024-01-01 00:00:00',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

    }
}
