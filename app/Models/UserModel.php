<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table          = 'users';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields  = [
        'full_name',
        'username',
        'email',
        'password_hash',
        'role',
        'last_login_at',
        'remember_token',
        'remember_expires_at',
    ];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';

    public function findByIdentity(string $identity): ?array
    {
        return $this->groupStart()
            ->where('username', $identity)
            ->orWhere('email', $identity)
            ->groupEnd()
            ->first();
    }

    public function createAdmin(array $data): int
    {
        if (isset($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        }

        $data['role'] ??= 'admin';

        return $this->insert($data, true);
    }

    public function recordLogin(int $userId): void
    {
        $this->update($userId, ['last_login_at' => date('Y-m-d H:i:s')]);
    }

    public function setRememberToken(int $userId, ?string $token, ?string $expires): void
    {
        $this->update($userId, [
            'remember_token'      => $token,
            'remember_expires_at' => $expires,
        ]);
    }

    public function findByRememberToken(string $token): ?array
    {
        return $this->where('remember_token', $token)
            ->where('remember_expires_at >=', date('Y-m-d H:i:s'))
            ->first();
    }
}

