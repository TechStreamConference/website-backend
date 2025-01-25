<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPossibleTalkDuration extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'talk_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('talk_id', 'Talk', 'id');
        $this->forge->addForeignKey('duration', 'TalkDurationChoice', 'duration');
        $this->forge->createTable('PossibleTalkDuration');
    }

    public function down(): void
    {
        $this->forge->dropTable('PossibleTalkDuration');
    }
}
