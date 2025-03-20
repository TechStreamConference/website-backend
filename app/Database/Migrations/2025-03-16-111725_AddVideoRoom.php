<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVideoRoom extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'event_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'base_url' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => 256,
            ],
            'room_id' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => 256,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => 256,
            ],
            'visible_from' => [
                'type' => 'DATETIME',
                'null' => true,
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
        $this->forge->addPrimaryKey('event_id');
        $this->forge->addForeignKey('event_id', 'Event', 'id');
        $this->forge->createTable('VideoRoom');
    }

    public function down()
    {
        $this->forge->dropTable('VideoRoom');
    }
}
