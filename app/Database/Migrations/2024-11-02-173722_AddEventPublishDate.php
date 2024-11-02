<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEventPublishDate extends Migration
{
    public function up()
    {
        $this->forge->addColumn('event', [
            'publish_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'description',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('event', 'publish_date');
    }
}
