<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Only the default admin account
        $admin = [
            'username'   => 'admin',
            'email'      => 'admin@lms.com',
            'password'   => password_hash('password123', PASSWORD_DEFAULT),
            'role'       => 'admin',
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // Insert admin if not exists (by email)
        $builder = $this->db->table('users');
        $existing = $builder->where('email', $admin['email'])->get()->getRow();

        if (! $existing) {
            $builder->insert($admin);
            echo "Inserted admin user: {$admin['email']}\n";
        } else {
            echo "Admin user already exists: {$admin['email']} - Skipping\n";
        }
    }
}
