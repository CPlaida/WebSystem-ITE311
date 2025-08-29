<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Sample users data
        $users = [
            [
                'username' => 'plaida1',
                'email' => 'admin@lms.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'role' => 'admin',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'kent2',
                'email' => 'instructor@lms.com',
                'password' => password_hash('instructor123', PASSWORD_DEFAULT),
                'first_name' => 'Aj',
                'last_name' => 'Roquero',
                'role' => 'instructor',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'labasa3',
                'email' => 'student@lms.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'first_name' => 'Zyf',
                'last_name' => 'Diga',
                'role' => 'student',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert users using query builder
        foreach ($users as $user) {
            $this->db->table('users')->insert($user);
        }
    }
}
