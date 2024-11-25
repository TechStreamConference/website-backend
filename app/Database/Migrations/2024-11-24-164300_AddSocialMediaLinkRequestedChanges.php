<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSocialMediaLinkRequestedChanges extends Migration
{
    public function up()
    {
        $this->forge->addColumn('SocialMediaLink', [
            'requested_changes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('SocialMediaLink', 'requested_changes');
    }
}
