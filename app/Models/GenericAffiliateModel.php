<?php

namespace App\Models;

use CodeIgniter\Model;

class GenericAffiliateModel extends Model
{
    // child classes will have to set the protected $table field to make this class work

    protected $allowedFields = ['event_id', 'url', 'logo', 'logo_mime_type', 'logo_alternative', 'logo_alternative_mime_type', 'name', 'alt_text', 'copyright', 'visible_from'];
    protected $useTimestamps = true;

    public function getPublished(int $eventId): array {
        return $this->db->table($this->table)
            ->select('url, logo, logo_mime_type, logo_alternative, logo_alternative_mime_type, name, copyright, alt_text')
            ->where('event_id', $eventId)
            ->where('visible_from <=', date('Y-m-d H:i:s'))
            ->get()
            ->getResultArray();
    }
}
