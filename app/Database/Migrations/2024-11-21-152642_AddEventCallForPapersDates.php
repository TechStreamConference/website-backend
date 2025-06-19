<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEventCallForPapersDates extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('Event', [
            'call_for_papers_start' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'description',
            ],
            'call_for_papers_end' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'call_for_papers_start',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('Event', 'call_for_papers_start');
        $this->forge->dropColumn('Event', 'call_for_papers_end');
    }
}
