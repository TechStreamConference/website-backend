<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('TeamMember')->insert([
            'name' => 'coder2k',
            'user_id' => 1,
            'event_id' => 1,
            'short_bio' => 'Test-Conf Host',
            'bio' => 'Das ist die Beschreibung von coder2k, wenn er als Team-Member angezeigt wird. Die ist anders als die Beschreibung, die angezeigt wird, wenn er als Speaker angezeigt wird.',
            'photo' => 'coder2k.jpg',
            'photo_mime_type' => 'image/jpeg',
            'is_approved' => true,
            'visible_from' => date('2024-06-01 15:00:00'),
            'updated_at' => date('2024-06-01 15:01:00'),
        ]);
        $this->db->table('TeamMember')->insert([
            'name' => 'codingPurpurTentakel',
            'user_id' => 4,
            'event_id' => 1,
            'short_bio' => 'Test-Conf Host',
            'bio' => 'Das ist die Beschreibung von codingPurpurTentakel, wenn er als Team-Member angezeigt wird. Die ist anders als die Beschreibung, die angezeigt wird, wenn er als Speaker angezeigt wird.',
            'photo' => 'images/codingPurpurTentakel.jpg',
            'photo_mime_type' => 'image/jpeg',
            'is_approved' => true,
            'visible_from' => date('2024-06-01 15:00:00'),
        ]);
    }
}
