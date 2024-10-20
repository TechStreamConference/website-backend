<?php

namespace App\Models;

use CodeIgniter\Model;

class GlobalsModel extends Model
{
    protected $table = 'Globals';
    protected $allowedFields = ['key', 'value'];
    protected $useTimestamps = true;

    private const REQUIRED_INT_KEYS = [
        "default_year",
    ];
    private const REQUIRED_STRING_KEYS = [
        "footer_text",
    ];

    public function read()
    {
        $data = $this->findAll();
        $result = [];
        foreach ($data as $row) {
            $key = $row['key'];
            $value = $row['value'];
            if (in_array($key, self::REQUIRED_INT_KEYS, true)) {
                $result[$key] = intval($value);
            } elseif (in_array($key, self::REQUIRED_STRING_KEYS, true)) {
                $result[$key] = $value;
            } else {
                return null;
            }
        }

        $missingKeys = array_diff(
            [...self::REQUIRED_INT_KEYS, ...self::REQUIRED_STRING_KEYS],
            array_keys($result)
        );
        if (count($missingKeys) !== 0) {
            return null;
        }

        return $result;
    }

    public function write(
        int    $default_year,
        string $footer_text,
    )
    {
        $this->where('key', 'default_year')->set(['value' => $default_year])->update();
        $this->where('key', 'footer_text')->set(['value' => $footer_text])->update();
    }
}