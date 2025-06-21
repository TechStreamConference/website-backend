<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserAndAccount extends Migration
{
    /**
     * @inheritDoc
     */
    public function up(): void
    {
        // Create User table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
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
        $this->forge->createTable('User');

        // Create Account table
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'unique' => true,
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 320,
                'unique' => true,
                'null' => false,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
                'null' => false,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'password_change_required' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
            'is_verified' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'email',
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
        $this->forge->createTable('Account');
    }

    /**
     * @inheritDoc
     */
    public function down(): void
    {
        // Drop tables in reverse order to avoid foreign key constraints
        $this->forge->dropTable('Account');
        $this->forge->dropTable('User');
    }
}