<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEvent extends Migration
{
    public function up()
    {
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
            'trailer_youtube_id' => [
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
    }

    public function down()
    {
        $this->forge->dropTable('Event');
    }
}
