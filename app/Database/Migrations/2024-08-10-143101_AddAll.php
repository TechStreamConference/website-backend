<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAll extends Migration
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

        // Create Event table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'subtitle' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => false,
            ],
            'start_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'end_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'discord_url' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'twitch_url' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'presskit_url' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'trailer_url' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'trailer_poster_url' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'description_headline' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'publish_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'description',
            ],
            'frontpage_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'description',
            ],
            'schedule_visible_from' => [
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
        $this->forge->createTable('Event');

        // Create Speaker table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'event_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
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
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => false,
            ],
            'photo_mime_type' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => false,
            ],
            'is_approved' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
            'visible_from' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'requested_changes' => [
                'type' => 'TEXT',
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
        $this->forge->addForeignKey('user_id', 'User', 'id');
        $this->forge->addForeignKey('event_id', 'Event', 'id');
        $this->forge->createTable('Speaker');
    }

    /**
     * @inheritDoc
     */
    public function down(): void
    {
        // Drop tables in reverse order to avoid foreign key constraints
        $this->forge->dropTable('Speaker');
        $this->forge->dropTable('Event');
        $this->forge->dropTable('Account');
        $this->forge->dropTable('User');
    }
}