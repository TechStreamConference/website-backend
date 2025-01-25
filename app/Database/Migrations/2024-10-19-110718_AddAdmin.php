<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdmin extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'unique' => true,
                'null' => false,
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
        $this->forge->addPrimaryKey('user_id');
        $this->forge->addForeignKey('user_id', 'User', 'id');
        $this->forge->createTable('Admin');
    }

    public function down(): void
    {
        $this->forge->dropTable('Admin');
    }
}
