<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSpeaker extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'short_bio' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'bio' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'photo' => [
                'type' => 'BLOB',
                'null' => false,
            ],
            'photo_mime_type' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
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
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('Speaker');
    }

    public function down()
    {
        $this->forge->dropTable('Speaker');
    }
}
