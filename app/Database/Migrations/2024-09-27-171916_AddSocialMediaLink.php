<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSocialMediaLink extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'social_media_type_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'speaker_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('social_media_type_id', 'SocialMediaType', 'id');
        $this->forge->addForeignKey('speaker_id', 'Speaker', 'id');
        $this->forge->createTable('SocialMediaLink');
    }

    public function down()
    {
        $this->forge->dropTable('SocialMediaLink');
    }
}
