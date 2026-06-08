<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Dev2024Seeder extends Seeder
{
    public function run(): void
    {
        $this->call('Dev2024EventSeeder');
        $this->call('Dev2024SpeakerSeeder');
    }
}
