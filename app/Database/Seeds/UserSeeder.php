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
                'name' => 'Cristine V. Plaida',
                'email' => 'admin@lms.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        // Insert users using query builder with duplicate check
        foreach ($users as $user) {
            // Check if user with this email already exists
            $existingUser = $this->db->table('users')
                ->where('email', $user['email'])
                ->get()
                ->getRow();
            
            if (!$existingUser) {
                // Only insert if user doesn't exist
                $this->db->table('users')->insert($user);
                echo "Inserted user: " . $user['email'] . "\n";
            } else {
                echo "User already exists: " . $user['email'] . " - Skipping\n";
            }
        }
    }
}
