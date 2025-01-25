<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTeamMemberRequestedChanges extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('TeamMember', [
            'requested_changes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('TeamMember', 'requested_changes');
    }
}
