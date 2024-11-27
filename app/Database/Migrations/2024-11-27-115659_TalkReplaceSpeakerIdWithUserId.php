<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TalkReplaceSpeakerIdWithUserId extends Migration
{
    public function up()
    {
        $this->forge->dropForeignKey('Talk', 'Talk_speaker_id_foreign');
        $this->forge->dropColumn('Talk', 'speaker_id');
        $this->forge->addColumn('Talk', [
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
                'after' => 'event_id',
            ],
        ]);
        $this->forge->addForeignKey('user_id', 'User', 'id');
    }

    public function down()
    {
        $this->forge->dropColumn('Talk', 'user_id');
        $this->forge->addColumn('Talk', [
            'speaker_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
                'after' => 'event_id',
            ],
        ]);
        $this->forge->addForeignKey('speaker_id', 'User', 'id');
    }
}
