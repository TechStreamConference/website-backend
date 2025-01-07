<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TalkReplaceSpeakerIdWithUserId extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `Talk`
            DROP FOREIGN KEY `Talk_speaker_id_foreign`;");
        $this->forge->dropColumn('Talk', 'speaker_id');
        $this->forge->addColumn('Talk', [
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
                'after' => 'event_id',
            ],
        ]);
        $this->db->query("ALTER TABLE `Talk`
            ADD CONSTRAINT `Talk_user_id_foreign`
                FOREIGN KEY (`user_id`)
                REFERENCES `User` (`id`);");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `Talk`
            DROP FOREIGN KEY `Talk_user_id_foreign`;");
        $this->forge->dropColumn('Talk', 'user_id');
        $this->forge->addColumn('Talk', [
            'speaker_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
                'after' => 'event_id',
            ],
        ]);
        $this->db->query("ALTER TABLE `Talk`
            ADD CONSTRAINT `Talk_speaker_id_foreign`
                FOREIGN KEY (`speaker_id`)
                REFERENCES `User` (`id`);");
    }
}
