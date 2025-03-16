<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GlobalsSeeder2024 extends Seeder
{
    public function run(): void
    {
        $this->db->table('Globals')->insert([
            'key' => 'footer_text',
            'value' => 'TECH STREAM CONFERENCE – Online-Konferenz mit Vorträgen aus den Bereichen Programmierung, Maker-Szene und Spieleentwicklung',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ]);
    }
}
