<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSpeakerRequestedChanges extends Migration
{
    public function up()
    {
        $this->forge->addColumn('Speaker', [
            'requested_changes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('Speaker', 'requested_changes');
    }
}
