<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTag extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'text' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'color_index' => [
                'type' => 'INT',
                'unsigned' => true,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('Tag');
    }

    public function down(): void
    {
        $this->forge->dropTable('Tag');
    }
}
