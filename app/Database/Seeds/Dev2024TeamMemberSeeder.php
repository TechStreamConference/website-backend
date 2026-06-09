<?php

namespace App\Database\Seeds;
include_once "DevBioEntry.php";

use CodeIgniter\Database\Seeder;


class Dev2024TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        // admin
        $this->db->table('TeamMember')->insert(
            [
                'name' => 'Admin',
                'user_id' => 1,
                'event_id' => 1,
                'short_bio' => 'Test-Conf Admin, ' . get_sort_bio(4),
                'bio' => 'Admin Description for 2024. '. get_bio_text(200),
                'photo' => 'admin.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => date('2024-06-01 15:00:00'),
                'updated_at' => date('2024-06-01 15:00:00'),
            ]
        );

        // team member
        $this->db->table('TeamMember')->insert(
            [
                'name' => 'Team Member',
                'user_id' => 3,
                'event_id' => 1,
                'short_bio' => 'Test-Conf Team Member, ' . get_sort_bio(4),
                'bio' => 'Team Member Description for 2024. ' . get_bio_text(200),
                'photo' => 'team_member.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => date('2024-06-01 15:00:00'),
                'updated_at' => date('2024-06-01 15:00:00'),
            ]
        );

        // generic
        foreach (range(16, 20) as $user_id) {
            $this->db->table('TeamMember')->insert(
                [
                    'name' => "Generic Team Member ($user_id)",
                    'user_id' => $user_id,
                    'event_id' => 1,
                    'short_bio' => 'Test-Conf Generic Team Member, ' . get_sort_bio(),
                    'bio' => 'Generic Team Member Description for 2024. ' . get_bio_text(),
                    'photo' => 'generic_team_member.jpg',
                    'photo_mime_type' => 'image/jpeg',
                    'is_approved' => true,
                    'visible_from' => date('2024-06-01 15:00:00'),
                    'updated_at' => date('2024-06-01 15:00:00'),
                ]
            );
        }

        // generic event
        $this->db->table('TeamMember')->insert(
            [
                'name' => "Event 1 Team Member",
                'user_id' => 27,
                'event_id' => 1,
                'short_bio' => 'Test-Conf Event 1 Team Member, ' . get_sort_bio(2),
                'bio' => 'Event 1 Team Member Description for 2024. ' . get_bio_text(125),
                'photo' => 'event_1.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => date('2024-06-01 15:00:00'),
                'updated_at' => date('2024-06-01 15:00:00'),
            ]
        );
    }
}

