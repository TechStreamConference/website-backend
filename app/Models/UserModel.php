<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'User';
    protected $allowedFields = [null];
    protected bool $allowEmptyInserts = true;
    protected $useTimestamps = true;

    /**
     * @param $id bool|int $id
     * @return array|object|null
     */
    public function getUser(bool|int $id = false): object|array|null
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }

    public function createUser(): int
    {
        return $this->insert([]);
    }
}
