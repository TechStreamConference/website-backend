<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSponsor extends Migration
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
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => false,
            ],
            'logo_mime_type' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => false,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'alt_text' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'copyright' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('event_id', 'Event', 'id');
        $this->forge->createTable('Sponsor');
    }

    public function down(): void
    {
        $this->forge->dropTable('Sponsor');
    }
}
