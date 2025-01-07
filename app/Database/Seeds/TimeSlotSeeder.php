<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    public function run()
    {
        // id: 1
        $this->db->table('TimeSlot')->insert([
            'event_id' => 1,
            'start_time' => '2024-06-22 13:00:00',
            'duration' => 45,
        ]);
        // id: 2
        $this->db->table('TimeSlot')->insert([
            'event_id' => 1,
            'start_time' => '2024-06-22 14:00:00',
            'duration' => 45,
        ]);
        // id: 3
        $this->db->table('TimeSlot')->insert([
            'event_id' => 1,
            'start_time' => '2024-06-22 15:00:00',
            'duration' => 30,
        ]);
        // id: 4
        $this->db->table('TimeSlot')->insert([
            'event_id' => 1,
            'start_time' => '2024-06-22 19:30:00',
            'duration' => 60,
        ]);
        // id: 5
        $this->db->table('TimeSlot')->insert([
            'event_id' => 1,
            'start_time' => '2024-06-23 11:00:00',
            'duration' => 45,
        ]);
        // id: 6
        $this->db->table('TimeSlot')->insert([
            'event_id' => 1,
            'start_time' => '2024-06-23 12:00:00',
            'duration' => 45,
        ]);
        // id: 7
        $this->db->table('TimeSlot')->insert([
            'event_id' => 1,
            'start_time' => '2024-06-23 13:00:00',
            'duration' => 45,
        ]);
        // id: 8
        $this->db->table('TimeSlot')->insert([
            'event_id' => 1,
            'start_time' => '2024-06-23 18:30:00',
            'duration' => 45,
        ]);
        // id: 9
        $this->db->table('TimeSlot')->insert([
            'event_id' => 1,
            'start_time' => '2024-06-23 19:30:00',
            'duration' => 60,
        ]);
    }
}
