<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGlobals extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'value' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('key');
        $this->forge->createTable('Globals');
    }

    public function down()
    {
        $this->forge->dropTable('Globals');
    }
}
