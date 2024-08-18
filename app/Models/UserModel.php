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

    public function deleteUser(int $id): bool
    {
        return $this->delete($id);
    }

    public function getRoles(int $userId): array|null
    {
        // todo: Should this be part of the user model? Should there be a dedicated role(s) model?
        $result = $this
            ->select('id, IF(user_id IS NULL, FALSE, TRUE) AS has_account', escape: false)
            ->join('Account', 'User.id = Account.user_id', 'left')
            ->where('User.id', $userId)
            ->first();
        if ($result === null) {
            return null;
        }
        return [
            'has_account' => boolval($result['has_account']),
        ];
    }
}
