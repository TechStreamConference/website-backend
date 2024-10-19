<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRolesView extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE VIEW Roles AS
            SELECT
                Account.user_id,
                Account.email,
                Account.username,
                IF(Speaker.user_id IS NOT NULL, TRUE, FALSE) AS is_speaker,
                IF(TeamMember.user_id IS NOT NULL, TRUE, FALSE) AS is_team_member,
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

    public function down()
    {
        $this->db->query('DROP VIEW Roles');
    }
}
