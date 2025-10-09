<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        // Resolve a valid user ID to use as instructor and enrollment user
        $userRow = $this->db->table('users')->select('id')->orderBy('id', 'ASC')->get(1)->getRowArray();
        if (!$userRow) {
            // No users exist; abort early with a clear message
            throw new \RuntimeException('No users found. Seed users first so instructor_id and user_id foreign keys can be satisfied.');
        }
        $validUserId = (int) $userRow['id'];

        $data = [
            [
                'title' => 'Introduction to Web Development',
                'description' => 'Learn the fundamentals of HTML, CSS, and JavaScript for building modern websites.',
                'instructor_id' => $validUserId,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Database Management Systems',
                'description' => 'Comprehensive course on database design, SQL, and data management principles.',
                'instructor_id' => $validUserId,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Advanced PHP Programming',
                'description' => 'Master PHP frameworks, object-oriented programming, and web application development.',
                'instructor_id' => $validUserId,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert courses
        foreach ($data as $course) {
            $this->db->table('courses')->insert($course);
        }

        // Re-fetch actual course IDs to ensure they exist before inserting enrollments
        $titles = array_column($data, 'title');
        $courseRows = $this->db->table('courses')
            ->select('id, title')
            ->whereIn('title', $titles)
            ->get()
            ->getResultArray();

        if (empty($courseRows)) {
            throw new \RuntimeException('Courses failed to insert or could not be fetched; aborting enrollments seeding.');
        }

        // Use the same valid user for enrollments (adjust if you need a specific student)
        $enrollments = [];
        foreach ($courseRows as $row) {
            $enrollments[] = [
                'user_id' => $validUserId,
                'course_id' => (int) $row['id'],
                'enrollment_date' => date('Y-m-d H:i:s')
            ];
        }

        foreach ($enrollments as $enrollment) {
            $this->db->table('enrollments')->insert($enrollment);
        }
    }
}
