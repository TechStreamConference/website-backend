<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEventPublishDate extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('Event', [
            'publish_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'description',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('event', 'publish_date');
    }
}
