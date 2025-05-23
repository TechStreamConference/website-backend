<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRolesView extends Migration
{
    public function up(): void
    {
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

    public function down(): void
    {
        $this->db->query('DROP VIEW Roles');
    }
}
