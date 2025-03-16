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
            'tag_id' => 40, // Maker
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 1,
            'tag_id' => 63, // Reverse Engeneering
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 1,
            'tag_id' => 31, // Hacking
        ]);


        // Journey eines Rollenspiels. Wie wir angefangen und was wir gelernt haben.

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 2,
            'tag_id' => 68, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 2,
            'tag_id' => 58, // Projektmanagement
        ]);


        // In Farbe und Bunt I - Wie werden Farben im Computer gemacht

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 3,
            'tag_id' => 57, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 3,
            'tag_id' => 12, // Computergrafik
        ]);


        // In Farbe und Bunt II - Wie werden Farben nicht im Computer gemacht

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 4,
            'tag_id' => 57, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 4,
            'tag_id' => 12, // Computergrafik
        ]);


        // Talk: Zwischen Code und Karriere: Soziale Dynamiken und der Übergang zum Beruf

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 5,
            'tag_id' => 21, // Didaktik
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 5,
            'tag_id' => 4, // Ausbildung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 5,
            'tag_id' => 35, // Kommunikation
        ]);


        // Der Mythos „Diamond Problem“

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 6,
            'tag_id' => 57, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 6,
            'tag_id' => 8, // C++
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 6,
            'tag_id' => 50, // Objektorientierung
        ]);


        // Kinder sind keine kleinen Erwachsenen

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 7,
            'tag_id' => 68, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 7,
            'tag_id' => 27, // Game Design
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 7,
            'tag_id' => 34, // Kindersoftware
        ]);


        // Hypewelle vs. loyaler Kern – Welche Community passt am besten zu dir?

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 8,
            'tag_id' => 69, // Streaming
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 8,
            'tag_id' => 11, // Community-Management
        ]);


        // WTF?! Wieso geht das nicht? Grrrrrrr

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 9,
            'tag_id' => 57, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 9,
            'tag_id' => 26, // Fehlerkultur
        ]);


        // Aftershow-Party

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 10,
            'tag_id' => 44, // Musik
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 10,
            'tag_id' => 54, // Party
        ]);


        // Sei nicht wie RockStar Games – lerne parsen in O(N)

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 11,
            'tag_id' => 57, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 11,
            'tag_id' => 7, // C
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 11,
            'tag_id' => 8, // C++
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 11,
            'tag_id' => 33, // JSON
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 11,
            'tag_id' => 53, // Parser
        ]);


        // Webentwicklung mit Symfony und Vue.js

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 12,
            'tag_id' => 81, // Web-Entwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 12,
            'tag_id' => 52, // PHP
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 12,
            'tag_id' => 72, // Symfony
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 12,
            'tag_id' => 80, // Vue.js
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 12,
            'tag_id' => 66, // Security
        ]);


        // Scriptable-Object-Listen in Unity

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 13,
            'tag_id' => 68, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 13,
            'tag_id' => 65, // Scriptable Objects
        ]);


        // Heiße Spur: Wie du mit Heatmaps herausfindest, was deine Spieler treiben

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 14,
            'tag_id' => 68, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 14,
            'tag_id' => 77, // Unity
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 14,
            'tag_id' => 27, // Game Design
        ]);


        // Talk: Von Code bis Community: Game Development, Softwareentwicklung und die Welt der Hackerspaces

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 15,
            'tag_id' => 40, // Maker
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 15,
            'tag_id' => 68, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 15,
            'tag_id' => 57, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 15,
            'tag_id' => 31, // Hacking
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 15,
            'tag_id' => 28, // Games-Branche
        ]);


        // Quasar und sonst nix

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 16,
            'tag_id' => 81, // Web-Entwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 16,
            'tag_id' => 60, // Quasar
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 16,
            'tag_id' => 80, // Vue.js
        ]);


        // Von Unity zu Unreal

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 17,
            'tag_id' => 68, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 17,
            'tag_id' => 77, // Unity
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 17,
            'tag_id' => 78, // Unreal
        ]);


        // Vom Skeptiker zum Fan: Wie du selbst deine Schwiegereltern von deinem Webdesign begeisterst

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 18,
            'tag_id' => 81, // Web-Entwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 18,
            'tag_id' => 75, // UI
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 18,
            'tag_id' => 76, // UX
        ]);


        // Autoritativer Multiplayer Game Server mit Node

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 19,
            'tag_id' => 68, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 19,
            'tag_id' => 48, // Node.js
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 19,
            'tag_id' => 43, // Multiplayer
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 19,
            'tag_id' => 46, // Netzwerk
        ]);


        // Spiele entwickeln war nie leichter...oder?

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 20,
            'tag_id' => 68, // Spieleentwicklung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 20,
            'tag_id' => 13, // Construct 3
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 20,
            'tag_id' => 28, // Games-Branche
        ]);


        // Ressourcenverwaltung unter C++

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 21,
            'tag_id' => 57, // Programmierung
        ]);

        $this->db->table('TalkHasTag')->insert([
            'talk_id' => 21,
            'tag_id' => 8, // C++
        ]);


    }
}
