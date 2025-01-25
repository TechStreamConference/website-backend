<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTalkDurationChoice extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'duration' => [
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
        $this->forge->addPrimaryKey('duration');
        $this->forge->createTable('TalkDurationChoice');
    }

    public function down(): void
    {
        $this->forge->dropTable('TalkDurationChoice');
    }
}
