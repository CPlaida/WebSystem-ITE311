<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;
use CodeIgniter\HTTP\ResponseInterface;

class Course extends BaseController
{
    public function enroll()
    {
        $session = session();

        // Must be logged in and student role
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'student') {
            return $this->response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                                   ->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        // Only allow POST/JSON
        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_METHOD_NOT_ALLOWED)
                                   ->setJSON(['success' => false, 'message' => 'Method not allowed']);
        }

        // Validate input
        $courseId = (int) $this->request->getPost('course_id');
        if ($courseId <= 0) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                   ->setJSON(['success' => false, 'message' => 'Invalid course ID']);
        }

        $db = \Config\Database::connect();
        // Ensure course exists and is active
        $course = $db->table('courses')->where('id', $courseId)->where('status', 'active')->get()->getRowArray();
        if (!$course) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                                   ->setJSON(['success' => false, 'message' => 'Course not found']);
        }

        $userId = (int) $session->get('userID');
        $enrollments = new EnrollmentModel();

        // Prevent duplicates
        if ($enrollments->isAlreadyEnrolled($userId, $courseId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Already enrolled']);
        }

        // Insert enrollment
        $ok = $enrollments->enrollUser([
            'user_id'         => (int) session()->get('userID'),
            'course_id'       => (int) $this->request->getPost('course_id'),
            'enrollment_date' => date('Y-m-d H:i:s'),
        ]);
       
        if (!$ok) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                                   ->setJSON(['success' => false, 'message' => 'Failed to enroll']);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Enrolled successfully',
            'course'  => [
                'id' => $course['id'],
                'title' => $course['title'],
                'description' => $course['description'] ?? '',
            ],
        ]);
    }

    public function list()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'student') {
            return redirect()->to('/login')->with('error', 'Please login as student.');
        }

        $userId = (int) $session->get('userID');
        $enrollModel = new EnrollmentModel();
        $enrolled = $enrollModel->getUserEnrollments($userId); // [id,title,description]
        $enrolledIds = array_map(fn($c) => (int) $c['id'], $enrolled);

        $db = \Config\Database::connect();
        $builder = $db->table('courses')->select('id, title, description')->where('status', 'active');
        if (!empty($enrolledIds)) {
            $builder->whereNotIn('id', $enrolledIds);
        }
        $available = $builder->get()->getResultArray();

        return view('student_courses', [
            'enrolledCourses' => $enrolled,
            'availableCourses' => $available,
        ]);
    }
}
