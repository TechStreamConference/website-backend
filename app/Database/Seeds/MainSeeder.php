<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('GlobalsSeeder');
        $this->call('TalkDurationChoiceSeeder');
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
        $this->call('TimeSlotSeeder');
        $this->call('TalkSeeder');
        $this->call('TalkHasTagSeeder');
        $this->call('AdminSeeder');
        $this->call('ConnectedRegistrationTokenSeeder');
    }
}
