<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $user = [
            'username' => 'farras',
            'email'    => 'farras@polban.ac.id',
            'password' => password_hash('farras', PASSWORD_DEFAULT),
            'full_name' => 'Nama Lengkap Admin',
            'role' => 'student'
        ];
        $this->db->table('users')->insert($user);

        $student = [
            'nim' => '241511010',
            'tanggal_lahir' => '2006-02-15',
            'user_id' => $this->db->insertID(),
            'entry_year' => '2024-01-01',
        ];
        $this->db->table('students')->insert($student);
    }
}
