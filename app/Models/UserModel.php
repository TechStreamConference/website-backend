<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'User';

    /**
     * @param $id bool|int $id
     * @return array|object|null
     */
    public function getUser(bool|int $id = false): object|array|null
    {
        if ($id === false) {
            return $this->findAll();
        } else {
            return $this->where(['id' => $id])->first();
        }
    }
}
