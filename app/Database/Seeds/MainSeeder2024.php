<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder2024 extends Seeder
{
    public function run(): void
    {
        $this->call('GlobalsSeeder2024');
        $this->call('TalkDurationChoiceSeeder2024');
        $this->call('UserSeeder2024');
        // $this->call('AccountSeeder');
        $this->call('EventSeeder2024');
        $this->call('SpeakerSeeder2024');
        $this->call('SocialMediaTypeSeeder2024');
        $this->call('SocialMediaLinkSeeder2024');
        $this->call('TeamMemberSeeder2024');
        $this->call('SponsorSeeder2024');
        $this->call('MediaPartnerSeeder2024');
        $this->call('TagSeeder2024');
        $this->call('TimeSlotSeeder2024');
        $this->call('TalkSeeder2024');
        $this->call('TalkHasTagSeeder2024');
        $this->call('AdminSeeder2024');
        // $this->call('ConnectedRegistrationTokenSeeder');
        $this->call('GuestSeeder2024');
    }
}
