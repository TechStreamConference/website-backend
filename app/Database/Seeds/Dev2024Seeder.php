<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Dev2024Seeder extends Seeder
{
    public function run(): void
    {
        $this->call('Dev2024EventSeeder');
        $this->call('Dev2024MediaPartnerSeeder');
        $this->call('Dev2024SponsorSeeder');
        $this->call('Dev2024SpeakerSeeder');
        $this->call('Dev2024TeamMemberSeeder');
        $this->call('Dev2024TimeSlotSeeder');
        $this->call('Dev2024TalkSeeder');
        $this->call('Dev2024GuestSeeder');
    }
}
