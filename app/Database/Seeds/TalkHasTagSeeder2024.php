<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TalkHasTagSeeder2024 extends Seeder
{
    public function run(): void
    {

        // Katzen würden VISCA senden

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 1,
            'tag_id' => 24, // Maker
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 1,
            'tag_id' => 16, // Reverse Engeneering
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 1,
            'tag_id' => 15, // Hacking
        ]);


        // Journey eines Rollenspiels. Wie wir angefangen und was wir gelernt haben.

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 2,
            'tag_id' => 4, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 2,
            'tag_id' => 56, // Projektmanagement
        ]);


        // In Farbe und Bunt I - Wie werden Farben im Computer gemacht

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 3,
            'tag_id' => 29, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 3,
            'tag_id' => 30, // Computergrafik
        ]);


        // In Farbe und Bunt II - Wie werden Farben nicht im Computer gemacht

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 4,
            'tag_id' => 29, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 4,
            'tag_id' => 30, // Computergrafik
        ]);


        // Talk: Zwischen Code und Karriere: Soziale Dynamiken und der Übergang zum Beruf

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 5,
            'tag_id' => 1, // Didaktik
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 5,
            'tag_id' => 2, // Ausbildung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 5,
            'tag_id' => 17, // Kommunikation
        ]);


        // Der Mythos „Diamond Problem“

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 6,
            'tag_id' => 29, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 6,
            'tag_id' => 32, // C++
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 6,
            'tag_id' => 39, // Objektorientierung
        ]);


        // Kinder sind keine kleinen Erwachsenen

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 7,
            'tag_id' => 4, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 7,
            'tag_id' => 6, // Game Design
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 7,
            'tag_id' => 3, // Kindersoftware
        ]);


        // Hypewelle vs. loyaler Kern – Welche Community passt am besten zu dir?

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 8,
            'tag_id' => 69, // Streaming
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 8,
            'tag_id' => 18, // Community-Management
        ]);


        // WTF?! Wieso geht das nicht? Grrrrrrr

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 9,
            'tag_id' => 29, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 9,
            'tag_id' => 60, // Fehlerkultur
        ]);


        // Aftershow-Party

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 10,
            'tag_id' => 28, // Musik
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 10,
            'tag_id' => 27, // Party
        ]);


        // Sei nicht wie RockStar Games – lerne parsen in O(N)

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 11,
            'tag_id' => 29, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 11,
            'tag_id' => 31, // C
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 11,
            'tag_id' => 32, // C++
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 11,
            'tag_id' => 73, // JSON
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 11,
            'tag_id' => 38, // Parser
        ]);


        // Webentwicklung mit Symfony und Vue.js

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 12,
            'tag_id' => 70, // Web-Entwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 12,
            'tag_id' => 37, // PHP
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 12,
            'tag_id' => 82, // Symfony
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 12,
            'tag_id' => 81, // Vue.js
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 12,
            'tag_id' => 67, // Security
        ]);


        // Scriptable-Object-Listen in Unity

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 13,
            'tag_id' => 4, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 13,
            'tag_id' => 9, // Scriptable Objects
        ]);


        // Heiße Spur: Wie du mit Heatmaps herausfindest, was deine Spieler treiben

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 14,
            'tag_id' => 4, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 14,
            'tag_id' => 7, // Unity
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 14,
            'tag_id' => 6, // Game Design
        ]);


        // Talk: Von Code bis Community: Game Development, Softwareentwicklung und die Welt der Hackerspaces

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 15,
            'tag_id' => 24, // Maker
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 15,
            'tag_id' => 4, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 15,
            'tag_id' => 29, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 15,
            'tag_id' => 15, // Hacking
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 15,
            'tag_id' => 5, // Games-Branche
        ]);


        // Quasar und sonst nix

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 16,
            'tag_id' => 70, // Web-Entwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 16,
            'tag_id' => 80, // Quasar
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 16,
            'tag_id' => 81, // Vue.js
        ]);


        // Von Unity zu Unreal

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 17,
            'tag_id' => 4, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 17,
            'tag_id' => 7, // Unity
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 17,
            'tag_id' => 8, // Unreal
        ]);


        // Vom Skeptiker zum Fan: Wie du selbst deine Schwiegereltern von deinem Webdesign begeisterst

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 18,
            'tag_id' => 70, // Web-Entwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 18,
            'tag_id' => 88, // UI
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 18,
            'tag_id' => 89, // UX
        ]);


        // Autoritativer Multiplayer Game Server mit Node

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 19,
            'tag_id' => 4, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 19,
            'tag_id' => 75, // Node.js
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 19,
            'tag_id' => 10, // Multiplayer
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 19,
            'tag_id' => 86, // Netzwerk
        ]);


        // Spiele entwickeln war nie leichter...oder?

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 20,
            'tag_id' => 4, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 20,
            'tag_id' => 11, // Construct 3
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 20,
            'tag_id' => 5, // Games-Branche
        ]);


        // Ressourcenverwaltung unter C++

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 21,
            'tag_id' => 29, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 21,
            'tag_id' => 32, // C++
        ]);


    }
}
