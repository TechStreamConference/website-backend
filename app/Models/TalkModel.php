<?php

namespace App\Models;

use CodeIgniter\Model;

class TalkModel extends Model
{
    protected $table = 'Talk';
    protected $allowedFields = ['event_id', 'speaker_id', 'starts_at', 'duration', 'title', 'description'];
    protected $useTimestamps = true;

    public function getByEventId(int $eventId): array
    {
        // get all talks for the given event
        $talks = $this->db->table('Talk')
            ->select('id, speaker_id, starts_at, duration, title, description')
            ->where('event_id', $eventId)
            ->orderBy('starts_at', 'ASC')
            ->get()
            ->getResultArray();

        // get all tags
        $tags = $this->db->table('TalkHasTag')
            ->join('Tag', 'Tag.id = TalkHasTag.tag_id')
            ->select('TalkHasTag.talk_id, Tag.text, Tag.color_index')
            ->get()
            ->getResultArray();

        // add tags to the talks
        foreach ($talks as &$talk) {
            $tagsForThisTalk = array_filter($tags, function ($tag) use ($talk) {
                return $tag['talk_id'] === $talk['id'];
            });

            // remove the talk_id from the tags
            foreach ($tagsForThisTalk as &$tag) {
                unset($tag['talk_id']);
            }

            $talk['tags'] = array_values($tagsForThisTalk);
        }

        // remove the id from the talks
        foreach ($talks as &$talk) {
            unset($talk['id']);
        }

        return $talks;
    }
}
