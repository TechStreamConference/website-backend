<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TimeSlotSeeder2024 extends Seeder
{
    public function run(): void
    {

        $this->db->table('TimeSlot')->insert([
            'id' => 1,
            'event_id' => 1,
            'start_time' => '2024-06-22 13:00:00',
            'duration' => 60,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 2,
            'event_id' => 1,
            'start_time' => '2024-06-22 14:00:00',
            'duration' => 60,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 3,
            'event_id' => 1,
            'start_time' => '2024-06-22 15:00:00',
            'duration' => 15,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 4,
            'event_id' => 1,
            'start_time' => '2024-06-22 15:15:00',
            'duration' => 15,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 5,
            'event_id' => 1,
            'start_time' => '2024-06-22 15:30:00',
            'duration' => 90,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 6,
            'event_id' => 1,
            'start_time' => '2024-06-22 17:00:00',
            'duration' => 60,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 7,
            'event_id' => 1,
            'start_time' => '2024-06-22 18:00:00',
            'duration' => 60,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 8,
            'event_id' => 1,
            'start_time' => '2024-06-22 19:00:00',
            'duration' => 60,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 9,
            'event_id' => 1,
            'start_time' => '2024-06-22 20:00:00',
            'duration' => 60,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 10,
            'event_id' => 1,
            'start_time' => '2024-06-22 21:00:00',
            'duration' => 120,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 11,
            'event_id' => 1,
            'start_time' => '2024-06-23 12:00:00',
            'duration' => 60,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 12,
            'event_id' => 1,
            'start_time' => '2024-06-23 13:00:00',
            'duration' => 60,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 13,
            'event_id' => 1,
            'start_time' => '2024-06-23 14:00:00',
            'duration' => 15,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 14,
            'event_id' => 1,
            'start_time' => '2024-06-23 14:15:00',
            'duration' => 15,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 15,
            'event_id' => 1,
            'start_time' => '2024-06-23 14:30:00',
            'duration' => 90,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 16,
            'event_id' => 1,
            'start_time' => '2024-06-23 16:00:00',
            'duration' => 30,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 17,
            'event_id' => 1,
            'start_time' => '2024-06-23 16:30:00',
            'duration' => 30,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 18,
            'event_id' => 1,
            'start_time' => '2024-06-23 17:00:00',
            'duration' => 15,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 19,
            'event_id' => 1,
            'start_time' => '2024-06-23 17:15:00',
            'duration' => 15,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 20,
            'event_id' => 1,
            'start_time' => '2024-06-23 17:30:00',
            'duration' => 60,
            'is_special' => false,
        ]);

        $this->db->table('TimeSlot')->insert([
            'id' => 21,
            'event_id' => 1,
            'start_time' => '2024-06-23 19:30:00',
            'duration' => 60,
            'is_special' => true,
        ]);

    }
}
