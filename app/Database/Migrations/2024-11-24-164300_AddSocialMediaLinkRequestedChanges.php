<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSocialMediaLinkRequestedChanges extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('SocialMediaLink', [
            'requested_changes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'approved',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('SocialMediaLink', 'requested_changes');
    }
}
