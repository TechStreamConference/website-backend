<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Dev2025TimeSlotSeeder extends Seeder
{
    public function run(): void
    {
        // id: 11
        $this->db->table('TimeSlot')->insert([
            'event_id' => 2,
            'start_time' => '2025-07-03 13:00:00',
            'duration' => 45,
            'is_special' => false,
        ]);
        // id: 12
        $this->db->table('TimeSlot')->insert([
            'event_id' => 2,
            'start_time' => '2025-07-03 14:00:00',
            'duration' => 45,
            'is_special' => false,
        ]);
        // id: 13
        $this->db->table('TimeSlot')->insert([
            'event_id' => 2,
            'start_time' => '2025-07-03 15:00:00',
            'duration' => 30,
            'is_special' => false,
        ]);
        // id: 14
        $this->db->table('TimeSlot')->insert([
            'event_id' => 2,
            'start_time' => '2025-07-03 19:30:00',
            'duration' => 60,
            'is_special' => true,
        ]);
        // id: 15
        $this->db->table('TimeSlot')->insert([
            'event_id' => 2,
            'start_time' => '2025-07-04 11:00:00',
            'duration' => 45,
            'is_special' => false,
        ]);
        // id: 16
        $this->db->table('TimeSlot')->insert([
            'event_id' => 2,
            'start_time' => '2025-07-04 12:00:00',
            'duration' => 45,
            'is_special' => false,
        ]);
        // id: 17
        $this->db->table('TimeSlot')->insert([
            'event_id' => 2,
            'start_time' => '2025-07-04 13:00:00',
            'duration' => 45,
            'is_special' => false,
        ]);
        // id: 18
        $this->db->table('TimeSlot')->insert([
            'event_id' => 2,
            'start_time' => '2025-07-04 18:30:00',
            'duration' => 45,
            'is_special' => false,
        ]);
        // id: 19
        $this->db->table('TimeSlot')->insert([
            'event_id' => 2,
            'start_time' => '2025-07-04 19:30:00',
            'duration' => 60,
            'is_special' => false,
        ]);
        // id: 20
        $this->db->table('TimeSlot')->insert([
            'event_id' => 2,
            'start_time' => '2025-07-04 20:45:00',
            'duration' => 45,
            'is_special' => true,
        ]);
    }
}
