<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TalkSeeder2024 extends Seeder
{
    public function run(): void
    {

        $this->db->table('Talk')->insert([
            'id' => 1,
            'event_id' => 1,
            'user_id' => 16,
            'title' => 'Katzen würden VISCA senden',
            'description' => 'Ich habe ein Paket unaufgefordert bekommen. In den nächsten Monaten habe ich etwa 500 € ausgegeben, den Webshop eines Onlinehändlers leer gekauft und einen kleinen Trend losgetreten',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 1,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=S_2-KUA34q4',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 2,
            'event_id' => 1,
            'user_id' => 14,
            'title' => 'Journey eines Rollenspiels. Wie wir angefangen und was wir gelernt haben.',
            'description' => 'Wir erzählen über unsere Erfahrungen und Erkenntnisse, von der Konzeption eines Open-World Rollenspiels, bis hin zu dessen Umsetzung.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 2,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=i5rRnURYl24',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 3,
            'event_id' => 1,
            'user_id' => 17,
            'title' => 'In Farbe und Bunt I - Wie werden Farben im Computer gemacht',
            'description' => 'In diesem Lightning-Talk präsentiere ich eine kurze Zusammenfassung darüber, wie Farben in einem Computer repräsentiert und dargestellt werden.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 3,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=txyt4bGWbkA',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 4,
            'event_id' => 1,
            'user_id' => 12,
            'title' => 'In Farbe und Bunt II - Wie werden Farben nicht im Computer gemacht',
            'description' => 'In diesem Lightning-Talk erkläre ich – aufbauend auf dem vorherigen Talk –, was Computerbildschirme bei der Farbdarstellung nicht machen und wie wir verblüffenderweise von unserem eigenen Gehirn getäuscht werden.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 4,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=txyt4bGWbkA',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 5,
            'event_id' => 1,
            'user_id' => 22,
            'title' => 'Talk: Zwischen Code und Karriere: Soziale Dynamiken und der Übergang zum Beruf',
            'description' => 'In dieser Diskussionsrunde geht es um die sozialen und didaktischen Aspekte des Programmierens. Wir möchten darüber sprechen, wie man Schülerinnen und Schüler für ein Studium in den MINT-Fächern (Mathematik, Informatik, Naturwissenschaften, Technik) begeistern kann. Die Vermittlung von Inhalten – sei es an Schulen oder Universitäten – stellt oft einen Kompromiss zwischen verschiedenen Vor- und Nachteilen dar. Diesen wollen wir auf den Grund gehen. 

Wir werden auch die Herausforderungen und Fragestellungen diskutieren, die der Übergang von der Ausbildung in den Beruf mit sich bringen. Dabei geht es z. B. um das Aufbauen eines eigenen Portfolios, die Stellensuche und das Fußfassen in der Branche im Allgemeinen.

 Darüber hinaus möchten wir weitere soziale Aspekte dieses sehr technischen Gebiets diskutieren: Wie wichtig ist der zwischenmenschliche Umgang? Stellt der Code, den wir schreiben, eine reine Liste von Kommandos für den Prozessor dar oder steckt darin in Wahrheit ein Kommunikationskanal mit uns selbst und anderen an der Entwicklung beteiligten Menschen?',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 5,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=i-Jz59VdsFg',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 6,
            'event_id' => 1,
            'user_id' => 7,
            'title' => 'Der Mythos „Diamond Problem“',
            'description' => 'Auch wenn es um Mehrfachvererbung geht, ist es nicht nur OOP. C++ ist eine Multiparadigmen-Sprache und auch hier verbinden wir Möglichkeiten der verschiedenen Paradigmen zu Lösungen.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 6,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=SyDVuZgKeBI',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 7,
            'event_id' => 1,
            'user_id' => 10,
            'title' => 'Kinder sind keine kleinen Erwachsenen',
            'description' => 'In diesem Talk geht es um die Learnings aus einem Jahr Spiele-Entwicklung bei Edurino, Game Design für die Zielgruppe 4 bis 8 Jahre, Kindergarting-Testing, Entwicklung und Projektmanagement.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 7,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=FSegqFaRPd8',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 8,
            'event_id' => 1,
            'user_id' => 2,
            'title' => 'Hypewelle vs. loyaler Kern – Welche Community passt am besten zu dir?',
            'description' => 'Die Vorbereitungen sind abgeschlossen und der Stream kann beginnen! Doch wer wird dich eigentlich gleich im Chat erwarten? In meinem Vortrag geht es darum, eine individuell passende Community zu kreieren, und warum das Ziel „umso mehr Zuschauer, desto besser“ nicht für jeden Streamer passt.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 8,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=hg_UHY98DdY',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 9,
            'event_id' => 1,
            'user_id' => 9,
            'title' => 'WTF?! Wieso geht das nicht? Grrrrrrr',
            'description' => 'Wieso Scheitern gut und wichtig ist. Bei diesem Talk handelt es sich um einen Einsteigervortrag über das Thema des Scheiterns und der Fehlerkultur in der Softwareentwicklung.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 9,
            'time_slot_accepted' => true,
            'youtube_url' => null, // Did not happen.
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 10,
            'event_id' => 1,
            'user_id' => 19,
            'title' => 'Aftershow-Party',
            'description' => 'Wir lassen den ersten Abend ausklingen mit einer fetten Party. Jekalez liefert als DJ die passende Musik. 🍻',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 10,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=LaVJEwGWpy8',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 11,
            'event_id' => 1,
            'user_id' => 3,
            'title' => 'Sei nicht wie RockStar Games – lerne parsen in O(N)',
            'description' => 'In diesem Talk geht es darum, effizient strukturierte Daten aus Textdateien zu holen – und zwar mit Werkzeugen, die älter sind als der durchschnittliche Zuschauer.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 11,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=EevAbkdPQNo',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 12,
            'event_id' => 1,
            'user_id' => 6,
            'title' => 'Webentwicklung mit Symfony und Vue.js',
            'description' => 'Wie man mit Symfony in der Webentwicklung startet und worauf man achten sollte.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 12,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=953jacwMXFM',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 13,
            'event_id' => 1,
            'user_id' => 5,
            'title' => 'Scriptable-Object-Listen in Unity',
            'description' => 'In diesem Lightning-Talk präsentiere ich eine Methode, SOs automatisiert in Listen zu aggregieren und Editor-Hooks auszuführen.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 13,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=H0_-X43fAfA',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 14,
            'event_id' => 1,
            'user_id' => 11,
            'title' => 'Heiße Spur: Wie du mit Heatmaps herausfindest, was deine Spieler treiben',
            'description' => 'Ich erzähle dir, wie du dein Spiel mit Heatmaps analysierst und warum du das tun solltest. Wie es dir beim Game Design, beim Bug Hunting oder auch bei der Priorisierung von Features helfen kann.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 14,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=Qixs_A_675c&pp=0gcJCb4JAYcqIYzv',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 15,
            'event_id' => 1,
            'user_id' => 21,
            'title' => 'Talk: Von Code bis Community: Game Development, Softwareentwicklung und die Welt der Hackerspaces',
            'description' => 'In dieser Diskussionsrunde werfen wir einen fokussierten technischen Blick auf die Programmier- und Spieleentwicklungs-Branche. Zunächst sprechen wir darüber, wie der Einstieg in diesen Sektor gelingen kann und wie der Arbeitsalltag aussieht. Speziell interessiert uns die Arbeit in der Spieleentwicklung: Welche Herausforderungen und Chancen bietet sie? Dabei beleuchten wir auch den Einsatz von Tools, etwa die Entscheidung zwischen einer kommerziellen Spiele-Engine und einer Eigenentwicklung. 

In einem ähnlichen Kontext, jedoch mit einem stärkeren Fokus auf die Community und kollaborative Aspekte der Technologie, widmen wir uns dann den Hackerspaces. Diese kreativen Orte bieten die Möglichkeit, Technologien gemeinschaftlich zu erforschen und weiterzuentwickeln. Wir erkunden, was Hackerspaces ausmacht, wie man dort Anschluss findet und welche Projekte und Lernmöglichkeiten sie bieten. Abschließend vertiefen wir uns in die technischen Details der täglichen Arbeit mit Code. Dazu gehören Themen wie der Umgang mit Versionierungssystemen wie Git, die Auswahl der optimalen Werkzeuge, Sicherheitsaspekte beim Programmieren sowie die neuesten Entwicklungen in der Programmiersprache C++. 

Diese Talkrunde enthält also ein ganzes Potpourri an interessanten Themen und verspricht tiefgehende Einblicke und spannende Diskussionen.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 15,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=K-N9tm92sTY',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 16,
            'event_id' => 1,
            'user_id' => 1,
            'title' => 'Quasar und sonst nix',
            'description' => 'In diesem Talk geht es darum, wie man mit Quasar Hybrid-Apps bauen kann – und zwar simpel und effektiv.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 16,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=RBEl-OmtY-g',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 17,
            'event_id' => 1,
            'user_id' => 13,
            'title' => 'Von Unity zu Unreal',
            'description' => 'In diesem Talk werden diverse Features von Unreal und Unity miteinander verglichen. Es wird versucht, eine (subjektive) Antwort auf die Frage zu finden, ob der Umstieg leicht ist.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 17,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=fqT9V4OhmT0',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 18,
            'event_id' => 1,
            'user_id' => 15,
            'title' => 'Vom Skeptiker zum Fan: Wie du selbst deine Schwiegereltern von deinem Webdesign begeisterst',
            'description' => 'Nichts bringt dir so viel über Usability und UI/UX bei wie der verzweifelte Blick deiner Schwiegereltern auf der Suche nach dem Checkout. Gutes Design ist eben mehr als nur hübsch: 7 bewährte Strategien für Webdesigns, die ankommen.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 18,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=lh0BiOVHb_E',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 19,
            'event_id' => 1,
            'user_id' => 20,
            'title' => 'Autoritativer Multiplayer Game Server mit Node',
            'description' => 'Einblick in Authorative Server und das Open Source Framework Colyseus.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 19,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=_bZZ7Ioga0M',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 20,
            'event_id' => 1,
            'user_id' => 8,
            'title' => 'Spiele entwickeln war nie leichter...oder? ',
            'description' => 'Ich entwickle ein Spiel in Construct 3 und demonstriere, wie schnell man einen Spiel-Prototypen entwickelt. Dazu erzähle ich eine kleine Geschichte, wie ich, ohne eine Bewerbung zu schreiben, trotzdem bei einem deutschen Spieleentwickler eingestellt wurde und dort viele Jahre gearbeitet habe.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 20,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=0h4WcxMh9Ws',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('Talk')->insert([
            'id' => 21,
            'event_id' => 1,
            'user_id' => 18,
            'title' => 'Ressourcenverwaltung unter C++',
            'description' => 'In diesem Talk geht es darum, wie man in C++ Ressourcensicherheit erreicht.',
            'requested_changes' => null,
            'is_approved' => true,
            'time_slot_id' => 21,
            'time_slot_accepted' => true,
            'youtube_url' => 'https://www.youtube.com/watch?v=7iHpRQ6NXVA',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

    }
}
