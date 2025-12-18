<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            'full_name'     => 'Super Admin',
            'username'      => 'admin',
            'email'         => 'admin@example.com',
            'password_hash' => password_hash('Admin123!', PASSWORD_DEFAULT),
            'role'          => 'admin',
            'created_at'    => $now,
            'updated_at'    => $now,
        ];

        $this->db->table('users')->ignore(true)->insert($data);
    }
}
