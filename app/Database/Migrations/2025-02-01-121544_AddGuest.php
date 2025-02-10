<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGuest extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'talk_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey(['talk_id', 'user_id']);
        $this->forge->addForeignKey('talk_id', 'Talk', 'id');
        $this->forge->addForeignKey('user_id', 'User', 'id');
        $this->forge->createTable('Guest');
    }

    public function down()
    {
        $this->forge->dropTable('Guest');
    }
}
