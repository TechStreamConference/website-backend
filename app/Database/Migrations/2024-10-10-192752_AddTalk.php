<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTalk extends Migration
{
    public function up()
    {
        // A talk is connected to an event and a speaker (both are foreign keys). It need's
        // data about the starting date and time, the duration, the title, and a description.
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'event_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
                'after' => 'event_id',
            ],
            'starts_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'duration' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 256,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'is_special' => [
                'type' => 'BOOLEAN',
                'null' => false,
                'default' => false,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('event_id', 'Event', 'id');
        $this->forge->addForeignKey('user_id', 'User', 'id');
        $this->forge->addForeignKey('duration', 'TalkDurationChoice', 'duration');
        $this->forge->createTable('Talk');
    }

    public function down()
    {
        $this->forge->dropTable('Talk');
    }
}
