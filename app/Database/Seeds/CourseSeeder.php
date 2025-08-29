<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Introduction to Web Development',
                'description' => 'Learn the fundamentals of HTML, CSS, and JavaScript for building modern websites.',
                'instructor_id' => 2,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Database Management Systems',
                'description' => 'Comprehensive course on database design, SQL, and data management principles.',
                'instructor_id' => 2,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Advanced PHP Programming',
                'description' => 'Master PHP frameworks, object-oriented programming, and web application development.',
                'instructor_id' => 2,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert courses
        foreach ($data as $course) {
            $this->db->table('courses')->insert($course);
        }

        // Insert sample enrollments
        $enrollments = [
            ['user_id' => 3, 'course_id' => 1, 'status' => 'active', 'enrolled_at' => date('Y-m-d H:i:s')],
            ['user_id' => 3, 'course_id' => 2, 'status' => 'active', 'enrolled_at' => date('Y-m-d H:i:s')],
            ['user_id' => 3, 'course_id' => 3, 'status' => 'active', 'enrolled_at' => date('Y-m-d H:i:s')]
        ];

        foreach ($enrollments as $enrollment) {
            $this->db->table('enrollments')->insert($enrollment);
        }
    }
}
