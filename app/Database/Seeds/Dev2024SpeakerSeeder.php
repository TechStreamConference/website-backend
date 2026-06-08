<?php

namespace App\Database\Seeds;
include "DevBioEntry.php";

use CodeIgniter\Database\Seeder;


class Dev2024SpeakerSeeder extends Seeder
{
    public function run(): void
    {
        // admin
        $this->db->table('Speaker')->insert(
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

        // speaker
        $this->db->table('Speaker')->insert(
            [
                'name' => 'Speaker',
                'user_id' => 2,
                'event_id' => 1,
                'short_bio' => 'Test-Conf Speaker, ' . get_sort_bio(1),
                'bio' => 'Speaker Description for 2024. ' . get_bio_text(100),
                'photo' => 'speaker.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => date('2024-06-01 15:00:00'),
                'updated_at' => date('2024-06-01 15:00:00'),
            ]
        );

        // generic
        foreach (range(6, 15) as $user_id) {
            $this->db->table('Speaker')->insert(
                [
                    'name' => "Generic Speaker ($user_id)",
                    'user_id' => $user_id,
                    'event_id' => 1,
                    'short_bio' => 'Test-Conf Generic Speaker, '  . get_sort_bio(),
                    'bio' => 'Generic Speaker Description for 2024. ' . get_bio_text(),
                    'photo' => 'generic_speaker.jpg',
                    'photo_mime_type' => 'image/jpeg',
                    'is_approved' => true,
                    'visible_from' => date('2024-06-01 15:00:00'),
                    'updated_at' => date('2024-06-01 15:00:00'),
                ]
            );
        }

        // generic event 1
        foreach (range(21, 23) as $user_id) {
            $this->db->table('Speaker')->insert(
                [
                    'name' => "Event 1 Speaker ($user_id)",
                    'user_id' => $user_id,
                    'event_id' => 1,
                    'short_bio' => 'Test-Conf Event 1 Speaker, '  . get_sort_bio(2),
                    'bio' => 'Event 1 Speaker Description for 2024. '. get_bio_text(125),
                    'photo' => 'event_1.jpg',
                    'photo_mime_type' => 'image/jpeg',
                    'is_approved' => true,
                    'visible_from' => date('2024-06-01 15:00:00'),
                    'updated_at' => date('2024-06-01 15:00:00'),
                ]
            );
        }

        // no social media links
        $this->db->table('Speaker')->insert(
            [
                'name' => 'No Social Media',
                'user_id' => 29,
                'event_id' => 1,
                'short_bio' => 'Test-Conf No Social Media',
                'bio' => 'No Social Media Description for 2024. '. get_bio_text(50),
                'photo' => 'no_social_media.jpg',
                'photo_mime_type' => 'image/jpeg',
                'is_approved' => true,
                'visible_from' => date('2024-06-01 15:00:00'),
                'updated_at' => date('2024-06-01 15:00:00'),
            ]
        );

    }
}

