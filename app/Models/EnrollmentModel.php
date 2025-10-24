<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table            = 'enrollments';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'course_id', 'enrollment_date'];
    protected $useTimestamps    = false;

    public function enrollUser(array $data): bool
    {
        // expects: user_id, course_id, enrollment_date
        return (bool) $this->insert($data, true);
    }

    public function isAlreadyEnrolled(int $userId, int $courseId): bool
    {
        return $this->where('user_id', $userId)
                    ->where('course_id', $courseId)
                    ->first() !== null;
    }

    public function getUserEnrollments(int $userId): array
    {
        // join with courses for display
        return $this->select('courses.*, enrollments.enrollment_date')
                    ->join('courses', 'courses.id = enrollments.course_id', 'inner')
                    ->where('enrollments.user_id', $userId)
                    ->findAll();
    }
}
