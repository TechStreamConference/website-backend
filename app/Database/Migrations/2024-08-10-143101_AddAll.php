<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAll extends Migration
{
    /**
     * @inheritDoc
     */
    public function up(): void
    {
        // Create SocialMediaType table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
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
        $this->forge->createTable('SocialMediaType');

        // Create User table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
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
        $this->forge->createTable('User');

        // Create Account table
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'unique' => true,
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 320,
                'unique' => true,
                'null' => false,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
                'null' => false,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'password_change_required' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
            'is_verified' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'email',
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
        $this->forge->addPrimaryKey('user_id');
        $this->forge->addForeignKey('user_id', 'User', 'id');
        $this->forge->createTable('Account');

        // Create Admin table
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'unique' => true,
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
        $this->forge->addPrimaryKey('user_id');
        $this->forge->addForeignKey('user_id', 'User', 'id');
        $this->forge->createTable('Admin');

        // Create SocialMediaLink table
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
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'approved' => [
                'type' => 'BOOLEAN',
                'null' => false,
                'default' => false,
                'after' => 'url',
            ],
            'requested_changes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'approved',
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
        $this->forge->addForeignKey('user_id', 'User', 'id');
        $this->forge->createTable('SocialMediaLink');

        // Create Event table
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
            'trailer_url' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'trailer_poster_url' => [
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
            'call_for_papers_start' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'description',
            ],
            'call_for_papers_end' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'call_for_papers_start',
            ],
            'publish_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'call_for_papers_end',
            ],
            'frontpage_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'publish_date',
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

        // Create Speaker table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'event_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'short_bio' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'bio' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'photo' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => false,
            ],
            'photo_mime_type' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => false,
            ],
            'is_approved' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
            'visible_from' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'requested_changes' => [
                'type' => 'TEXT',
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
        $this->forge->addForeignKey('user_id', 'User', 'id');
        $this->forge->addForeignKey('event_id', 'Event', 'id');
        $this->forge->createTable('Speaker');

        // Create TeamMember table (same structure as Speaker)
        // The TeamMember table has the same structure as the Speaker table
        $speakerTableFields = $this->db->getFieldData('Speaker');

        $fields = [];
        $fields['id'] = [
            'type' => 'INT',
            'unsigned' => true,
            'auto_increment' => true,
        ];

        foreach ($speakerTableFields as $field) {
            if ($field->name === 'id') {
                continue;
            }
            $fields[$field->name] = [
                'type' => $field->type,
                'constraint' => $field->max_length ?? null,
                'unsigned' => $field->unsigned ?? false,
                'null' => $field->nullable ?? false,
                'default' => $field->default ?? null,
            ];
        }

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('TeamMember');

        // Create Sponsor table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'event_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => false,
            ],
            'logo_mime_type' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => false,
            ],
            'logo_alternative' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
            ],
            'logo_alternative_mime_type' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'alt_text' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'copyright' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'visible_from' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('event_id', 'Event', 'id');
        $this->forge->createTable('Sponsor');

        // Create MediaPartner table (same structure as Sponsor)
        $sponsorTableFields = $this->db->getFieldData('Sponsor');

        $fields = [];
        $fields['id'] = [
            'type' => 'INT',
            'unsigned' => true,
            'auto_increment' => true,
        ];

        foreach ($sponsorTableFields as $field) {
            if ($field->name === 'id') {
                continue;
            }
            $fields[$field->name] = [
                'type' => $field->type,
                'constraint' => $field->max_length ?? null,
                'unsigned' => $field->unsigned ?? false,
                'null' => $field->nullable ?? false,
                'default' => $field->default ?? null,
            ];
        }

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('MediaPartner');

        // Create TalkDurationChoice table
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

        // Create TimeSlot table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'event_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'start_time' => [
                'type' => 'DATETIME',
            ],
            'duration' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'is_special' => [
                'type' => 'BOOLEAN',
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
        $this->forge->addForeignKey('event_id', 'Event', 'id');
        $this->forge->createTable('TimeSlot');

        // Create Tag table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'text' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'color_index' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('Tag');

        // Create Talk table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'event_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
                'after' => 'event_id',
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 256,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'requested_changes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'is_special',
            ],
            'is_approved' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'requested_changes',
            ],
            'time_slot_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
                'after' => 'is_approved',
            ],
            'time_slot_accepted' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'time_slot_id',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('event_id', 'Event', 'id');
        $this->forge->addForeignKey('user_id', 'User', 'id');
        $this->forge->addForeignKey('time_slot_id', 'TimeSlot', 'id');
        $this->forge->createTable('Talk');

        // Create TalkHasTag table
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

        // Create Globals table
        $this->forge->addField([
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'value' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('key');
        $this->forge->createTable('Globals');

        // Create VerificationToken table
        $this->forge->addField([
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'expires_at' => [
                'type' => 'DATETIME',
            ],
            'new_email' => [
                'type' => 'VARCHAR',
                'constraint' => 320,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('token');
        $this->forge->addForeignKey('user_id', 'User', 'id');
        $this->forge->createTable('VerificationToken');

        // Create PasswordResetToken table
        $this->forge->addField([
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'expires_at' => [
                'type' => 'DATETIME',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('token');
        $this->forge->addForeignKey('user_id', 'User', 'id');
        $this->forge->createTable('PasswordResetToken');

        // Create Roles view
        $this->db->query("
            CREATE VIEW Roles AS
            SELECT
                Account.user_id,
                Account.email,
                Account.username,
                EXISTS (
                    SELECT 1
                    FROM Speaker
                    WHERE Speaker.user_id = Account.user_id AND (
                        Speaker.is_approved = TRUE
                        OR Speaker.requested_changes IS NOT NULL
                    )
                ) AS is_speaker,
                EXISTS (
                    SELECT 1
                    FROM TeamMember
                    WHERE TeamMember.user_id = Account.user_id AND (
                        TeamMember.is_approved = TRUE
                        OR TeamMember.requested_changes IS NOT NULL
                    )
                ) AS is_team_member,
                IF(Admin.user_id IS NOT NULL, TRUE, FALSE) AS is_admin
            FROM
                Account
                    LEFT JOIN
                Speaker ON Account.user_id = Speaker.user_id
                    LEFT JOIN
                TeamMember ON Account.user_id = TeamMember.user_id
                    LEFT JOIN
                Admin ON Account.user_id = Admin.user_id
            GROUP BY user_id
        ");
    }

    /**
     * @inheritDoc
     */
    public function down(): void
    {
        // Drop tables in reverse order to avoid foreign key constraints
        $this->db->query('DROP VIEW Roles');
        $this->forge->dropTable('TalkHasTag');
        $this->forge->dropTable('Talk');
        $this->forge->dropTable('Tag');
        $this->forge->dropTable('TimeSlot');
        $this->forge->dropTable('TalkDurationChoice');
        $this->forge->dropTable('MediaPartner');
        $this->forge->dropTable('Sponsor');
        $this->forge->dropTable('TeamMember');
        $this->forge->dropTable('Speaker');
        $this->forge->dropTable('SocialMediaLink');
        $this->forge->dropTable('VerificationToken');
        $this->forge->dropTable('PasswordResetToken');
        $this->forge->dropTable('Event');
        $this->forge->dropTable('Admin');
        $this->forge->dropTable('Account');
        $this->forge->dropTable('User');
        $this->forge->dropTable('SocialMediaType');
        $this->forge->dropTable('Globals');
    }
}
