<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DevCoreDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->call('DevGlobalsSeeder');
        $this->call('DevSocialMediaTypeSeeder');
        $this->call('DevTagSeeder');
        $this->call('DevTalkDurationChoiceSeeder');
        $this->call('DevUserSeeder');
        $this->call('DevAccountSeeder');
        $this->call('DevAdminSeeder');
        $this->call('DevConnectedRegistrationTokenSeeder');
        $this->call('DevSocialMediaLinkSeeder');
    }
}
