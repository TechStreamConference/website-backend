<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SpeakerSeeder2024 extends Seeder
{
    public function run(): void
    {

        $this->db->table('Speaker')->insert(
            [
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
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'Limquats',
                'user_id' => 2,
                'event_id' => 1,
                'short_bio' => 'Art Streamerin, Game Design Dozentin, Community Managerin',
                'bio' => 'Du fühlst dich von der Realität ausgelaugt? Dann sind Lims Live-Streams der perfekte Ort, um durchzuatmen. Kunst & gute Laune stehen in ihrem Obstkorb an erster Stelle. Dabei zeigt sie ihren Früchtchen die Höhen und Tiefen einer selbstständigen Künstlerin oder bringt sie mit ihrer Tollpatschigkeit in Videospielen zum Schmunzeln. Wenn sie nicht auf Twitch zu sehen ist, bildet sie als Dozentin die nächste Generation an Game Designern aus.',
                'photo' => 'limquats.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'GyrosGeier',
                'user_id' => 3,
                'event_id' => 1,
                'short_bio' => 'Embedded- und Lowlevel-Coding',
                'bio' => 'GyrosGeier hat nicht nur einen witzigen Namen – nein – er kennt sich auch ziemlich gut im Bereich der Low-Level- bzw. Systemprogrammierung aus. Im vergangenen Jahr ist er nach Tokyo ausgewandert und arbeitet dort für eine Firma, die Mikrosatelliten ins Weltall schießt. In seinen Streams bastelt er an zahlreichen Projekten und vergisst niemals, den Yak-Stapel zu vergrößern.',
                'photo' => 'gyros_geier.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'herrhotzenplotz',
                'user_id' => 4,
                'event_id' => 1,
                'short_bio' => 'FreeBSD, C, low-level, Unix',
                'bio' => 'Low-leveliger, hardwarenaher und unixoider Kram: Hier wird gern mit unixoiden Betriebssystemen gebastelt - vor allem FreeBSD. Oft gesehen sind: Softwarepaketierung für FreeBSD und Portsmaintainence, Portables Kommandozeilentool namens \'gcli\' - ein Client für verschiedene git Hoster, Comaintainer der Schilytools, einer Kollektion von Tools, die vor allem für cdrecord bekannt ist, Treiber für ein uraltes Netzwerkprotokoll',
                'photo' => 'herrhotzenplotz.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'Artimus83',
                'user_id' => 5,
                'event_id' => 1,
                'short_bio' => 'Webdev, Gamer, Pixelart, 80s, Cosplay',
                'bio' => 'Vor 30 Jahren packte Artimus der Gedanke eigene Games zu entwickeln und seitdem ist er dem Coding verfallen. Beruflich tätig als Specialist Frontend Developer entwickelt er privat Spiele wie Schlacht um Kyoto, Stream Battlecards und seit 4 Jahren A World of Little Legends. Artimus besuchte in den 90ern zwei Kunstschulen und zeigt daher in seinen Streams nicht nur das Coding, sondern auch die Pixel Art zu seinen Games.',
                'photo' => 'artimus83.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'joeel561',
                'user_id' => 6,
                'event_id' => 1,
                'short_bio' => 'Webdevs, Cyber Security, Symfony, VueJs, Webapps',
                'bio' => 'In Joeels Livesstreams geht es hauptsaechlich um Webentwicklung & neue Dinge in der Programmierung zu lernen dabei supportet Alexander sie mit seiner Erfahrung.',
                'photo' => 'joeel561.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'Volker',
                'user_id' => 7,
                'event_id' => 1,
                'short_bio' => 'C++ Programmierer, Buchautor, Trainer, Berater',
                'bio' => 'Volker Hillmann geboren 1965, studierte Mathematik mit dem Schwerpunkt Datenbanken und Datensicherheit an der Universität Rostock. Er programmiert seit 1988 in C. Nach ersten Berührungen auf Unix- Rechner mit Turbo C auf PCs. Ab 1991 programmiert er in unterschiedlichen Bereichen mit C++. Nach Erfahrungen im Versicherungs- und Bankwesen gründete er im Jahr 2000 die adecc Systemhaus GmbH. Er ist auch Buchautor, Trainer und Berater.',
                'photo' => 'volker.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'SculptyFix',
                'user_id' => 8,
                'event_id' => 1,
                'short_bio' => '2D Artist, 3D Artist, 2D Animator, 3D Animator',
                'bio' => 'Jens (Sculptyfix) ist seit über 17 Jahren in der Gaming Branche aktiv. Davon 12 Jahre als Character Artist und  Animator sowie die letzten 5.5 Jahre Environment Artist bei Piranha Bytes. Seit kurzem wieder als Freiberufler tätig und entwickelt ein eigenes Spiel Spitfire – Moonpie´s Mission.',
                'photo' => 'sculpty_fix.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'chrisfigge',
                'user_id' => 9,
                'event_id' => 1,
                'short_bio' => 'programmieren, löten, drucken',
                'bio' => 'Chris baut Dinge. Kompromisslos. Von der Idee, über\'s Programmieren, Drucken und Löten. Wenn er eine Idee hat muss sie umgesetzt werden. Egal wie lange es dauert, egal wie bekloppt. Aufgeben ist keine Option.',
                'photo' => 'chrisfigge.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'anywaygame',
                'user_id' => 10,
                'event_id' => 1,
                'short_bio' => 'Unity, Spiele-Entwicklung, NRW, Edurino',
                'bio' => 'Anyway ist ein Indie-Spieleprojekt, das 2020 von ein paar Studenten der Universität Duisburg Essen gestartet wurde und 2022 auf Steam released wurde. Der Twitch-Kanal wird noch sporadisch von Kathi betrieben. Sie selbst arbeitet mittlerweile beruflich als Spiele-Entwicklerin bei Edurino und hat mit den Sneaky Elephant Games ein Indie-Kollektiv gegründet, das sich hobbymäßig auf Gamejams herumtreibt und mit Spiele-Entwicklung beschäftigt.',
                'photo' => 'anywaygame.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'Gandi',
                'user_id' => 11,
                'event_id' => 1,
                'short_bio' => 'Unity Developer, Game Designer',
                'bio' => 'Sein Name ist Michael Gantner, aber alle nennen ihn Gandi. Er ist ein Unity Developer und Game Designer aus Aachen. Im Laufe vieler Projekte hat er viel Erfahrung gesammelt. Seine ersten Versuche mit der Unity Game Engine unternahm er schon 2016. Von dort aus hat er seine Fähigkeiten durch ein Studium der Informatik, die Teilnahme an zahlreichen Game Jams und die Erstellung eines Asset-Pakets für den Unity Asset Store weiterentwickelt.',
                'photo' => 'gandi.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'JHKrueger',
                'user_id' => 12,
                'event_id' => 1,
                'short_bio' => 'Coding, Computer Graphics, Retro-Computing, IoT, Besserwisser',
                'bio' => 'JHKrueger, bürgerlich Jens Krüger, widmet sich in seiner Freizeit dem Basteln an alten Computern, vorzugsweise von Commodore, sowie modernen Haussteuerungen. Beruflich leitet er die Fachgruppe für Computergrafik und Visualisierung an der Fakultät für Informatik der Universität Duisburg-Essen. Um den Lehrbetrieb während der Corona-Pandemie aufrechterhalten zu können, verlegte er seine Vorlesungen auf Twitch und nutzt dieses Medium seitdem immer mal wieder, um sein Wissen über verschiedene Themen zu teilen.',
                'photo' => 'jhkrueger.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'Isa',
                'user_id' => 13,
                'event_id' => 1,
                'short_bio' => 'Indie-Game-Developer, CEO, Unreal-Engine & Unity-user',
                'bio' => 'Wenn sie nicht gerade Rehe im Garten beobachtet oder vor den schwedischen Mücken wegrennt, findet man Isa am Coden oder 3D-Modeln. Sie lebt in Schweden und arbeitet dort an ihrem Spiel „Magical Harvest“, dessen Entwicklung vor mehr als 2 Jahren in Unity begann und nun in Unreal Engine umgesetzt wird. Durch das Leiten einer eigenen Indie-Company hat sie weitreichende Kenntnisse in der Game-Branche aufgebaut.',
                'photo' => 'isa.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'EntwicklerWG',
                'user_id' => 14,
                'event_id' => 1,
                'short_bio' => 'OpenWorld, RPG, Spieleentwicklung, Unity',
                'bio' => 'Wir sind Johannes und Chris von der EntwicklerWG und arbeiten fleißig an unserem Open World Pixel Art Rollenspiel namens Drova Forsaken Kin. In der Uni haben wir uns kennengelernt und gründeten unser eigenes Studio Just2d, wo wir mit 9 Leuten an unserem Traum, ein Rollenspiel zu entwickeln arbeiten.',
                'photo' => 'entwickler_wg.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'PropzMaster',
                'user_id' => 15,
                'event_id' => 1,
                'short_bio' => 'Creative Chaos Director, Designer, Webdev',
                'bio' => 'Mit über einem Jahrzehnt Erfahrung als Agenturinhaber und Kreativ-Direktor hat propz einen einzigartigen Blick auf Design und Webentwicklung entwickelt. Mit einer großen Portion Kreativität und einem Auge für Usability und UX ist er bekannt dafür, komplexe Probleme in ansprechende Lösungen zu verwandeln. Als leidenschaftlicher Streamer & Nerd sucht Propz stets nach kreativen Wegen, um Menschen zu inspirieren und ihr Potenzial zu entfalten.',
                'photo' => 'propz_master.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'JvPeek',
                'user_id' => 16,
                'event_id' => 1,
                'short_bio' => '3D Druck, Mikrocontroller, Shitposting, Softwareentwicklung, Linux',
                'bio' => 'JvPeek nutzt viel zu komplizierte Technologien, um dämliche Shitposts im Internet zu produzieren. Im Stream kannst du als Benutzer Seifenblasen auslösen, den Streamer mit Schaumstoffpfeilen abschießen und Dinge aus dem Regal werfen.',
                'photo' => 'jv_peek.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'OwlOrientedProgramming',
                'user_id' => 17,
                'event_id' => 1,
                'short_bio' => 'Computer Graphics & Scientific Vis Newcomer, Handlager von JHKrueger',
                'bio' => 'Sie war von den ersten komplett Computer-generierten Animationsfilmen total geflasht und träumte davon, irgendwann einmal selbst bei Pixar zu arbeiten. Den elterlichen Wünschen entsprechend, versuchte sie zunächst etwas Ordentliches zu lernen... um dann mit Umwegen letzenendes doch in der Computergrafik zu landen. ;-)',
                'photo' => 'owl_oriented_programming.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'coder2k',
                'user_id' => 18,
                'event_id' => 1,
                'short_bio' => 'Test-Conf Host,  Software-Entwickler, freier Dozent, Twitch-Partner',
                'bio' => 'Michael (coder2k) hat vor über 20 Jahren \'Turbo Pascal und Delphi für Kids\' gelesen und sich seitdem mit dem Programmieren in verschiedenen Programmiersprachen beschäftigt. Er ist tätig als Software-Entwickler im Embedded-Umfeld und freier Dozent. Seit drei Jahren programmiert er auch auf Twitch und ist seit Anfang 2024 Twitch-Partner. Michael ist es wichtig, Wissen mit anderen auszutauschen und sich dadurch gemeinsam weiterzuentwickeln und neue Dinge zu lernen – und daraus ist auch die Idee zur Test-Conf entstanden.',
                'photo' => 'coder2k.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'Jekalez',
                'user_id' => 19,
                'event_id' => 1,
                'short_bio' => 'DJ, Podcaster, Producer, Streamer',
                'bio' => 'Jekalez steht inzwischen seit über 20 Jahren hinter den DJ-Decks und hat in der Vergangenheit sämtliche Festivals, Open-Air-Veranstaltungen und Clubs bespielt. Er ist bekannt für seine unbändige Liebe für basslastige Musik und energiereichen DJ-Sets. Wenn er einmal im Flow ist, kreiert er eine ganz besondere Atmosphäre, die Gunfingers und \'Skank\'-Mimiken zum Vorschein bringen. In der Vergangenheit hat er einige Mash-Ups von bekannten Lieder gemacht, die zum Teil schon über 10K Plays auf Soundcloud haben. Auf Twitch kann man ihm mehrmals in der Woche bei seiner Leidenschaft zusehen und er reißt seine Zuschauer, mit seiner Feinfühligkeit, Kreativität und einer Affinität zum Musikerleben jedes Mal aufs Neue mit.',
                'photo' => 'jekalez.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'Jonas Voland',
                'user_id' => 20,
                'event_id' => 1,
                'short_bio' => 'Softwareentwicklung, Spieleentwicklung, Musikproduktion, Kreativität',
                'bio' => 'Als Softwareentwickler fokussiert er sich auf innovative Lösungen und komplexe Problemlösungen. Neben seinem Beruf ist er leidenschaftlicher Spieleentwickler und Musikproduzent, wo er seine Kreativität und Fähigkeiten ständig weiterentwickelt.',
                'photo' => 'jonas_voland.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'Bobo',
                'user_id' => 21,
                'event_id' => 1,
                'short_bio' => 'Network Co-founder and 3D Art Enthusiast',
                'bio' => 'Willkommen im Netzwerk - Unter diesem Motto verknüpft Bobo mit viel Freude die unterschiedlichsten Personen in der Games Branche miteinander. Auf Youtube findet man seine Blender Kurse und gemeinsam mit den Kollegen produzierten Indiegame Tests.',
                'photo' => 'bobo.png',
                'photo_mime_type' => 'image/png',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

        $this->db->table('Speaker')->insert(
            [
                'name' => 'Andi',
                'user_id' => 22,
                'event_id' => 1,
                'short_bio' => 'Network Co-founder and Programmer',
                'bio' => 'So genau weiß er selbst nicht, was er alles macht. Andi findet man als Mentor, Speaker, Moderator und Dozent sowohl vor als auch hinter der Kamera und auf (fast) jedem Event. Wenn noch Zeit vorhanden ist, programmiert er auch mal gerne an Spielen und Apps herum.',
                'photo' => 'andi.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => '2024-01-01 00:00:00',
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => '2024-01-01 00:00:00',
            ]
        );

    }
}
