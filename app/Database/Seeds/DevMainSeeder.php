<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DevMainSeeder extends Seeder
{
    public function run(): void
    {
        $this->call('DevCoreDataSeeder');
        $this->call('DevEventsSeeder');
    }
}
