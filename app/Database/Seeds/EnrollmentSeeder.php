<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 3, // Student ID from UserSeeder
                'course_id' => 1, // Introduction to Web Development
                'enrolled_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 3, // Student ID from UserSeeder
                'course_id' => 2, // Database Management Systems
                'enrolled_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('enrollments')->insertBatch($data);
    }
}
