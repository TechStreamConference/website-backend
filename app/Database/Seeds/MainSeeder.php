<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('AccountSeeder');
        $this->call('EventSeeder');
        $this->call('SpeakerSeeder');
        $this->call('SocialMediaTypeSeeder');
        $this->call('SocialMediaLinkSeeder');
        $this->call('TeamMemberSeeder');
        $this->call('SponsorSeeder');
        $this->call('MediaPartnerSeeder');
        $this->call('TagSeeder');
        $this->call('TalkSeeder');
        $this->call('TalkHasTagSeeder');
    }
}
