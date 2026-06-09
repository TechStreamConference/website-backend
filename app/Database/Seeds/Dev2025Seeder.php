<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Dev2025Seeder extends Seeder
{
    public function run(): void
    {
        $this->call('Dev2025EventSeeder');
        $this->call('Dev2025MediaPartnerSeeder');
        $this->call('Dev2025SponsorSeeder');
        // $this->call('Dev2025SpeakerSeeder');
        // $this->call('Dev2025TeamMemberSeeder');
        // $this->call('Dev2025TimeSlotSeeder');
        // $this->call('Dev2025TalkSeeder');
        // $this->call('Dev2025GuestSeeder');
        // $this->call('Dev2025TalkHasTagSeeder');
    }
}
