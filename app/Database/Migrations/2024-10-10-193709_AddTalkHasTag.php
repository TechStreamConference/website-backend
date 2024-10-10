<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTalkHasTag extends Migration
{
    public function up()
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
                'null' => false,
            ],
            'tag_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('talk_id', 'Talk', 'id');
        $this->forge->addForeignKey('tag_id', 'Tag', 'id');
        $this->forge->createTable('TalkHasTag');
    }

    public function down()
    {
        $this->forge->dropTable('TalkHasTag');
    }
}
