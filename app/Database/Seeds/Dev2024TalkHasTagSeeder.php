<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Dev2024TalkHasTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags_ids = [21, 4, 34]; // color_index 1, 2
        $this->seedTags(1, $tags_ids);

        $tags_ids = [68, 3, 13, 27, 28, 77, 78, 79]; // color_index 3, 4
        $this->seedTags(2, $tags_ids);

        $tags_ids = [31, 63, 35, 11]; // color_index 5, 6, 7, 8
        $this->seedTags(3, $tags_ids);

        $tags_ids = [38, 5, 19, 18, 39]; // color_index 9, 10
        $this->seedTags(4, $tags_ids);

        $tags_ids = [40, 24, 32, 44, 54]; // color_index 11, 12, 13
        $this->seedTags(5, $tags_ids);

        $tags_ids = [57, 22, 23, 29, 30, 36, 37, 41, 50, 51, 52]; // color_index 15, 16
        $this->seedTags(6, $tags_ids);

        $tags_ids = [58, 2, 14, 25, 26, 45, 59]; // color_index 17, 18
        $this->seedTags(7, $tags_ids);

        $tags_ids = [66, 17]; // color_index 19, 20
        $this->seedTags(8, $tags_ids);

        $tags_ids = [69]; // color_index 21, 22
        $this->seedTags(9, $tags_ids);

        $tags_ids = [81, 46, 47, 48, 49, 60, 61, 70, 72, 75, 76]; // color_index 23, 24
        $this->seedTags(10, $tags_ids);
    }

    private function seedTags(int $talk_id, array $tag_ids): void
    {
        foreach ($tag_ids as $tag_id) {
            $this->db->table('TalkHasTag')->insert([
                'talk_id' => $talk_id,
                'tag_id' => $tag_id,
            ]);
        }
    }
}
