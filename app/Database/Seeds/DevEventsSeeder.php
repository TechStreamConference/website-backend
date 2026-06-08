<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DevEventsSeeder extends Seeder
{
    public function run(): void
    {
        $this->call('Dev2024Seeder');
    }
}
