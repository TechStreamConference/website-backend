<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddConnectedRegistrationToken extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
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
        $this->forge->addPrimaryKey('token');
        $this->forge->addForeignKey('user_id', 'User', 'id');
        $this->forge->createTable('ConnectedRegistrationToken');
    }

    public function down(): void
    {
        $this->forge->dropTable('ConnectedRegistrationToken');
    }
}
