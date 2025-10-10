<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Ensure there is at least one instructor (teacher/admin) for FK
        $user = $db->table('users')
            ->whereIn('role', ['teacher', 'admin'])
            ->get()
            ->getRowArray();

        if (!$user) {
            // Create a fallback teacher
            $db->table('users')->insert([
                'username'   => 'instructor1',
                'email'      => 'instructor1@example.com',
                'password'   => password_hash('password', PASSWORD_DEFAULT),
                'role'       => 'teacher',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $instructorId = (int) $db->insertID();
        } else {
            $instructorId = (int) $user['id'];
        }

        // Your desired default courses
        $courses = [
            [
                'title'         => 'Web System and Development',
                'description'   => 'This course teaches the basic skills in creating websites using HTML, CSS, and JavaScript.',
                'instructor_id' => $instructorId,
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'title'         => 'Advance Database System',
                'description'   => 'This course focuses on database design, SQL commands, and data management techniques.',
                'instructor_id' => $instructorId,
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'title'         => 'System Analysis and Design',
                'description'   => 'This course covers the steps and methods in analyzing, designing, and developing information systems.',
                'instructor_id' => $instructorId,
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert only if not already present (by unique title)
        foreach ($courses as $course) {
            $exists = $db->table('courses')->where('title', $course['title'])->get()->getRowArray();
            if (!$exists) {
                $db->table('courses')->insert($course);
            }
        }
    }
}