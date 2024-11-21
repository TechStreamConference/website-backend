<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSocialMediaLinkApproved extends Migration
{
    public function up()
    {
        $this->forge->addColumn('SocialMediaLink', [
            'approved' => [
                'type' => 'BOOLEAN',
                'null' => false,
                'default' => false,
                'after' => 'url',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('SocialMediaLink', 'approved');
    }
}
