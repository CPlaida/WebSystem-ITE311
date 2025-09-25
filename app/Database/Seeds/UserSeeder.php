<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $users = [
            [
                'username'   => 'admin',
                'email'      => 'admin@lms.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username'   => 'teacher',
                'email'      => 'teacher@lms.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'teacher',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username'   => 'student',
                'email'      => 'student@lms.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'student',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $builder = $this->db->table('users');
        foreach ($users as $user) {
            $existing = $builder->where('email', $user['email'])->get()->getRow();
            if (! $existing) {
                $builder->insert($user);
                echo "Inserted user: {$user['email']}\n";
            } else {
                echo "User already exists: {$user['email']} - Skipping\n";
            }
        }
    }
}