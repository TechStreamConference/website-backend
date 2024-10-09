<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMediaPartner extends Migration
{
    public function up()
    {
        // The MediaPartner table and the Sponsor table are exactly identical, except
        // for their name. Therefore, we can reuse the Sponsor table fields for the
        // MediaPartner table.
        $sponsorTableFields = $this->db->getFieldData('Sponsor');

        $fields = [];
        foreach ($sponsorTableFields as $field) {
            $fields[$field->name] = [
                'type' => $field->type,
                'constraint' => $field->max_length ?? null,
                'unsigned' => $field->unsigned ?? false,
                'null' => $field->null ?? false,
                'default' => $field->default ?? null,
                'auto_increment' => $field->name === 'id',
            ];
        }

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('MediaPartner');
    }

    public function down()
    {
        $this->forge->dropTable('MediaPartner');
    }
}
