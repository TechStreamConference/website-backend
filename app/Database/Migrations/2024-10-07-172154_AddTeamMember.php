<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTeamMember extends Migration
{
    public function up(): void
    {
        // The Speaker table and the TeamMember table are exactly identical, except
        // for their name. Therefore, we can reuse the Speaker table fields for the
        // TeamMember table.
        $speakerTableFields = $this->db->getFieldData('Speaker');

        $fields = [];
        foreach ($speakerTableFields as $field) {
            $fields[$field->name] = [
                'type' => $field->type,
                'constraint' => $field->max_length ?? null,
                'unsigned' => $field->unsigned ?? false,
                'null' => $field->nullable ?? false,
                'default' => $field->default ?? null,
                'auto_increment' => $field->name === 'id',
            ];
        }

        // fixed strange behavior of copying the id field
        unset($fields['id']);

        $fields['id'] = [
            'type' => 'INT',
            'unsigned' => true,
            'auto_increment' => true,
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('TeamMember');
    }

    public function down(): void
    {
        $this->forge->dropTable('TeamMember');
    }
}
