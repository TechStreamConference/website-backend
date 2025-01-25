<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAccountIsVerified extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('Account', [
            'is_verified' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'email',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('Account', 'is_verified');
    }
}
