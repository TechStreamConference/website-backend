<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTalk extends Migration
{
    public function up(): void
    {
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
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 256,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'requested_changes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'is_special',
            ],
            'is_approved' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'requested_changes',
            ],
            'time_slot_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
                'after' => 'is_approved',
            ],
            'time_slot_accepted' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'time_slot_id',
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
        $this->forge->addForeignKey('time_slot_id', 'TimeSlot', 'id');
        $this->forge->createTable('Talk');
    }

    public function down(): void
    {
        $this->forge->dropTable('Talk');
    }
}
