<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'student_id' => null,
                'username' => 'admin',
                'email'    => 'admin@polban.ac.id',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'full_name' => 'Nama Lengkap Admin',
                'role' => 'admin'
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
