<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GlobalsSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('Globals')->insert([
            'key' => 'footer_text',
            'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ac ante mollis, fermentum nunc nec, tincidunt nunc. Sed nec nunc nec nunc.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
