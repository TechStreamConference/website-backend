<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVerificationToken extends Migration
{
    public function up()
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
            'expires_at' => [
                'type' => 'DATETIME',
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
        $this->forge->createTable('VerificationToken');
    }

    public function down()
    {
        $this->forge->dropTable('VerificationToken');
    }
}
