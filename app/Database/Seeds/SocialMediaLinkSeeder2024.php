<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SocialMediaLinkSeeder2024 extends Seeder
{
    public function run(): void
    {

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 1, // LordRepha
            'url' => 'https://github.com/lordrepha1980',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 1, // LordRepha
            'url' => 'https://discord.gg/qxxzypje',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 1, // LordRepha
            'url' => 'https://www.twitch.tv/lordrepha',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 1, // LordRepha
            'url' => 'https://christoph-duengel.de',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 4, // LinkedIn
            'user_id' => 1, // LordRepha
            'url' => 'https://www.linkedin.com/in/christoph-d%C3%BCngel-3a038164/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 2, // Limquats
            'url' => 'https://discord.gg/W3Brs3q',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 2, // Limquats
            'url' => 'https://twitch.tv/limquats',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 2, // Limquats
            'url' => 'https://lottaburmester.wixsite.com/portfolio',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 4, // LinkedIn
            'user_id' => 2, // Limquats
            'url' => 'https://www.linkedin.com/in/lotta-burmester-6601b1167',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 6, // Instagram
            'user_id' => 2, // Limquats
            'url' => 'https://instagram.com/limquats',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 3, // GyrosGeier
            'url' => 'https://gitlab.com/GyrosGeier',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 3, // GyrosGeier
            'url' => 'https://twitch.tv/GyrosGeier',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 3, // GyrosGeier
            'url' => 'https://hachyderm.io/@GyrosGeier',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 4, // herrhotzenplotz
            'url' => 'https://github.com/herrhotzenplotz',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 4, // herrhotzenplotz
            'url' => 'https://twitch.tv/herrhotzenplotz',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 4, // herrhotzenplotz
            'url' => 'https://herrhotzenplotz.de/gcli',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 5, // Artimus83
            'url' => 'https://github.com/Artimon',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 5, // Artimus83
            'url' => 'https://discord.gg/AWPcAfC',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 5, // Artimus83
            'url' => 'https://www.twitch.tv/artimus83',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 5, // Artimus83
            'url' => 'https://pad-soft.de/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 6, // Instagram
            'user_id' => 5, // Artimus83
            'url' => 'https://www.instagram.com/lunatic.artimus/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 5, // YouTube
            'user_id' => 5, // Artimus83
            'url' => 'https://www.youtube.com/@lunaticartimus',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 7, // X
            'user_id' => 5, // Artimus83
            'url' => 'https://twitter.com/LunaticArtimus',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 6, // joeel561
            'url' => 'https://github.com/joeel561',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 6, // joeel561
            'url' => 'https://discord.com/invite/QqR6bPD',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 6, // joeel561
            'url' => 'https://www.twitch.tv/joeel561',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 4, // LinkedIn
            'user_id' => 6, // joeel561
            'url' => 'https://www.linkedin.com/in/joeel56/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 5, // YouTube
            'user_id' => 6, // joeel561
            'url' => 'https://www.youtube.com/channel/UCaTUjHIaC0i5X-5OAY76mQQ',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 6, // Instagram
            'user_id' => 6, // joeel561
            'url' => 'https://www.instagram.com/joeel56/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 7, // Volker
            'url' => 'https://github.com/adeccscholar',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 7, // Volker
            'url' => 'https://discord.com/invite/E8tzbu2FTY ',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 7, // Volker
            'url' => 'https://www.twitch.tv/volker_adecc',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 4, // LinkedIn
            'user_id' => 7, // Volker
            'url' => 'https://www.linkedin.com/in/volker-hillmann-38a50622a/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 6, // Instagram
            'user_id' => 7, // Volker
            'url' => 'https://www.instagram.com/volker_hillmann/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 5, // YouTube
            'user_id' => 7, // Volker
            'url' => 'https://www.youtube.com/@adeccScholar',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 7, // X
            'user_id' => 7, // Volker
            'url' => 'https://twitter.com/volkerhi',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 7, // Volker
            'url' => 'https://adecc.de',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 8, // SculptyFix
            'url' => 'https://discord.gg/ZYtSACVa4W',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 8, // SculptyFix
            'url' => 'https://www.twitch.tv/sculptyfix',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 4, // LinkedIn
            'user_id' => 8, // SculptyFix
            'url' => 'https://www.linkedin.com/in/jens-pöhlmann-51395553/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 6, // Instagram
            'user_id' => 8, // SculptyFix
            'url' => 'https://www.instagram.com/sculptyfix/?hl=de',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 5, // YouTube
            'user_id' => 8, // SculptyFix
            'url' => 'https://www.youtube.com/@RennYifu',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 8, // SculptyFix
            'url' => 'https://www.patreon.com/Sculptyfix',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 9, // chrisfigge
            'url' => 'https://twitch.tv/chrisfigge',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 9, // chrisfigge
            'url' => 'http://discord.zackbummfertig.tv',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 9, // chrisfigge
            'url' => 'https://github.com/flazer',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 9, // chrisfigge
            'url' => 'https://flazer.com/blog ',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 4, // LinkedIn
            'user_id' => 9, // chrisfigge
            'url' => 'https://www.linkedin.com/in/christian-figge-88908a57/ ',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 5, // YouTube
            'user_id' => 9, // chrisfigge
            'url' => 'https://www.youtube.com/@chrisfigge ',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 7, // X
            'user_id' => 9, // chrisfigge
            'url' => 'https://twitter.com/nerdpole ',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 6, // Instagram
            'user_id' => 9, // chrisfigge
            'url' => 'https://www.instagram.com/flazer/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 10, // anywaygame
            'url' => 'https://www.twitch.tv/anywaygame',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 10, // anywaygame
            'url' => 'https://discord.gg/5BFZhSteAt ',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 10, // anywaygame
            'url' => 'https://anywaygame.wordpress.com/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 4, // LinkedIn
            'user_id' => 10, // anywaygame
            'url' => 'https://www.linkedin.com/in/kahzn/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 5, // YouTube
            'user_id' => 10, // anywaygame
            'url' => 'https://www.youtube.com/@anywayteam7146',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 6, // Instagram
            'user_id' => 10, // anywaygame
            'url' => 'https://www.instagram.com/anywaygame/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 11, // Gandi
            'url' => 'https://github.com/MichiGandi',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 11, // Gandi
            'url' => 'https://michael-gantner.de/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 4, // LinkedIn
            'user_id' => 11, // Gandi
            'url' => 'https://www.linkedin.com/in/michael-gantner-472920289/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 12, // JHKrueger
            'url' => 'https://www.twitch.tv/JHKrueger',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 12, // JHKrueger
            'url' => 'https://github.com/JensDerKrueger',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 12, // JHKrueger
            'url' => 'https://www.cgvis.de/krueger.shtml',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 13, // Isa
            'url' => 'https://www.twitch.tv/isaviigames',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 13, // Isa
            'url' => 'https://discord.gg/cDCx4SyPkG',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 13, // Isa
            'url' => 'https://moonflamegames.games/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 4, // LinkedIn
            'user_id' => 13, // Isa
            'url' => 'https://www.linkedin.com/in/isa-hellström-229aa6187/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 5, // YouTube
            'user_id' => 13, // Isa
            'url' => 'https://www.youtube.com/channel/UC6xvVglSEN8JBX6h01iNMtg',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 7, // X
            'user_id' => 13, // Isa
            'url' => 'https://twitter.com/MagicalHarvest',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 14, // EntwicklerWG
            'url' => 'https://www.twitch.tv/entwicklerwg',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 14, // EntwicklerWG
            'url' => 'https://discord.gg/3YqsAvNRmT',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 14, // EntwicklerWG
            'url' => 'https://www.just2d.com',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 5, // YouTube
            'user_id' => 14, // EntwicklerWG
            'url' => 'https://www.youtube.com/@Just2DInteractive',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 7, // X
            'user_id' => 14, // EntwicklerWG
            'url' => 'https://twitter.com/J2D_Interactive',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 6, // Instagram
            'user_id' => 14, // EntwicklerWG
            'url' => 'https://www.instagram.com/just2d_interactive/?hl=de',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 15, // PropzMaster
            'url' => 'https://www.twitch.tv/propzmaster',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 15, // PropzMaster
            'url' => 'https://propz.de/discord/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 15, // PropzMaster
            'url' => 'https://propz.de/github/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 15, // PropzMaster
            'url' => 'https://propz.de/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 4, // LinkedIn
            'user_id' => 15, // PropzMaster
            'url' => 'https://propz.de/linkedin/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 5, // YouTube
            'user_id' => 15, // PropzMaster
            'url' => 'https://propz.de/youtube/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 7, // X
            'user_id' => 15, // PropzMaster
            'url' => 'https://propz.de/twitter/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 16, // JvPeek
            'url' => 'https://twitch.tv/JvPeek',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 16, // JvPeek
            'url' => 'https://discord.jvpeek.de',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 16, // JvPeek
            'url' => 'https://github.com/JvPeek',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 16, // JvPeek
            'url' => 'https://jvpeek.de',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 5, // YouTube
            'user_id' => 16, // JvPeek
            'url' => 'https://youtube.com/@JvPeek',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 7, // X
            'user_id' => 16, // JvPeek
            'url' => 'https://twitter.com/JvPeek',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 6, // Instagram
            'user_id' => 16, // JvPeek
            'url' => 'https://instagram.com/JvPeek',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 17, // OwlOrientedProgramming
            'url' => 'https://www.twitch.tv/OwlOrientedProgramming',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 18, // coder2k
            'url' => 'https://www.twitch.tv/coder2k',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 18, // coder2k
            'url' => 'https://discord.gg/CtFebtPRJK',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 18, // coder2k
            'url' => 'https://github.com/mgerhold/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 6, // Instagram
            'user_id' => 18, // coder2k
            'url' => 'https://www.instagram.com/coder2k/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 19, // Jekalez
            'url' => 'https://www.twitch.tv/jekalez',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 19, // Jekalez
            'url' => 'http://discord.gg/KSmmQSRNHE',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 19, // Jekalez
            'url' => 'https://soundcloud.com/jekalez',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 5, // YouTube
            'user_id' => 19, // Jekalez
            'url' => 'https://www.youtube.com/@Jekalez',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 6, // Instagram
            'user_id' => 19, // Jekalez
            'url' => 'https://www.instagram.com/jekalez/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 20, // Jonas Voland
            'url' => 'https://jonasvoland.me',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 20, // Jonas Voland
            'url' => 'https://github.com/Wenish',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 23, // CrazyNightowl01
            'url' => 'https://www.twitch.tv/crazynightowl01',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 5, // YouTube
            'user_id' => 24, // NoodyDraws
            'url' => 'https://www.youtube.com/channel/UC54wEBdXybVhrNENGoctPTQ',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 24, // NoodyDraws
            'url' => 'https://discord.gg/wxW5sQkHMm',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 24, // NoodyDraws
            'url' => 'https://www.twitch.tv/noodydraws',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 1, // Web
            'user_id' => 24, // NoodyDraws
            'url' => 'https://www.noody.de',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 4, // LinkedIn
            'user_id' => 24, // NoodyDraws
            'url' => 'https://www.linkedin.com/in/kerstin-buzelan-51421999/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 7, // X
            'user_id' => 24, // NoodyDraws
            'url' => 'https://www.x.com/noodydraws',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 6, // Instagram
            'user_id' => 24, // NoodyDraws
            'url' => 'https://www.instagram.com/noodydraws/',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 9, // GitHub
            'user_id' => 25, // codingPurpurTentakel
            'url' => 'https://github.com/PurpurTentakel97',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 3, // Discord
            'user_id' => 25, // codingPurpurTentakel
            'url' => 'https://discord.gg/JG5fsFZqEE',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

        $this->db->table('SocialMediaLink')->insert([
            'social_media_type_id' => 2, // Twitch
            'user_id' => 25, // codingPurpurTentakel
            'url' => 'https://www.twitch.tv/codingpurpurtentakel',
            'approved' => true,
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);

    }
}
