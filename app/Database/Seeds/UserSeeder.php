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
                'Fname' => 'Cristine',
                'Lname' => 'Plaida',
                'MI' => 'V.',
                'email' => 'admin@lms.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'Admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'Fname' => 'Kent',
                'Lname' => 'Felica',
                'MI' => 'B.',
                'email' => 'instructor@lms.com',
                'password' => password_hash('instructor123', PASSWORD_DEFAULT),
                'role' => 'Instructor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'Fname' => 'Frenchie',
                'Lname' => 'Labasa',
                'MI' => 'D.',
                'email' => 'student@lms.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'Student',
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
