<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;
use CodeIgniter\HTTP\ResponseInterface;

class Course extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function adminCourses()
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please login first.');
            return redirect()->to(base_url('login'));
        }

        if (session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('dashboard'));
        }

        $courses = $this->db->table('courses')
                           ->select('courses.*, users.username as instructor_name')
                           ->join('users', 'users.id = courses.instructor_id', 'left')
                           ->where('courses.status', 'active')
                           ->get()
                           ->getResultArray();

        return view('materials/list', [
            'courses' => $courses,
            'user' => [
                'name' => session()->get('name') ?? session()->get('username'),
                'role' => session()->get('role')
            ]
        ]);
    }

    public function teacherClasses()
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please login first.');
            return redirect()->to(base_url('login'));
        }

        if (session()->get('role') !== 'teacher') {
            session()->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('dashboard'));
        }

        $teacherId = session()->get('userID');
        $classes = $this->db->table('courses')
                           ->where('instructor_id', $teacherId)
                           ->where('status', 'active')
                           ->get()
                           ->getResultArray();

        // If the teacher has at least one class, open the upload/materials interface
        // for the first class so the page matches the two-column upload+materials UI.
        if (!empty($classes)) {
            $firstCourseId = $classes[0]['id'];
            return redirect()->to(base_url('materials/upload/' . $firstCourseId));
        }

        // No classes assigned to this teacher - show all active courses so
        // the teacher can still upload materials (allow upload to any course).
        $allCourses = $this->db->table('courses')
                               ->select('courses.*, users.username as instructor_name')
                               ->join('users', 'users.id = courses.instructor_id', 'left')
                               ->where('courses.status', 'active')
                               ->get()
                               ->getResultArray();

        return view('materials/list', [
            'classes' => $allCourses,
            'user' => [
                'name' => session()->get('name') ?? session()->get('username'),
                'role' => session()->get('role')
            ]
        ]);
    }

    public function enroll()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'student') {
            return $this->response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                               ->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_METHOD_NOT_ALLOWED)
                               ->setJSON(['success' => false, 'message' => 'Method not allowed']);
        }

        $courseId = (int) $this->request->getPost('course_id');
        if ($courseId <= 0) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                               ->setJSON(['success' => false, 'message' => 'Invalid course ID']);
        }

        $course = $this->db->table('courses')
                          ->where('id', $courseId)
                          ->where('status', 'active')
                          ->get()
                          ->getRowArray();

        if (!$course) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                               ->setJSON(['success' => false, 'message' => 'Course not found']);
        }

        $userId = (int) session()->get('userID');
        $enrollments = new EnrollmentModel();

        if ($enrollments->isAlreadyEnrolled($userId, $courseId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Already enrolled']);
        }

        $saved = $enrollments->enrollUser([
            'user_id' => $userId,
            'course_id' => $courseId,
            'enrollment_date' => date('Y-m-d H:i:s'),
        ]);
        if ($saved) {
            try {
                $nm = new \App\Models\NotificationModel();

                // Notify the student
                $nm->insert([
                    'user_id' => $userId,
                    'message' => 'You have enrolled in: ' . ($course['title'] ?? ('Course #' . $courseId)),
                    'is_read' => 0,
                ]);

                // Notify the course instructor (if exists)
                $instructorId = (int)($course['instructor_id'] ?? 0);
                if ($instructorId > 0) {
                    $nm->insert([
                        'user_id' => $instructorId,
                        'message' => 'A student enrolled in your course: ' . ($course['title'] ?? ('Course #' . $courseId)),
                        'is_read' => 0,
                    ]);
                }

                // Always notify ALL teachers as well (role exactly 'teacher')
                $teacherIds = $this->db->table('users')
                    ->select('id')
                    ->where('role', 'teacher')
                    ->get()->getResultArray();
                foreach ($teacherIds as $t) {
                    $tid = (int)($t['id'] ?? 0);
                    if ($tid > 0 && $tid !== $instructorId) { // avoid duplicate for instructor
                        $nm->insert([
                            'user_id' => $tid,
                            'message' => 'A student enrolled in: ' . ($course['title'] ?? ('Course #' . $courseId)),
                            'is_read' => 0,
                        ]);
                    }
                }

                // Notify all admins
                $adminIds = $this->db->table('users')->select('id')->where('role', 'admin')->get()->getResultArray();
                foreach ($adminIds as $a) {
                    $aid = (int)($a['id'] ?? 0);
                    if ($aid > 0) {
                        $nm->insert([
                            'user_id' => $aid,
                            'message' => 'New enrollment in ' . ($course['title'] ?? ('Course #' . $courseId)),
                            'is_read' => 0,
                        ]);
                    }
                }
            } catch (\Throwable $e) {
            }

            // Flash success for next page load
            session()->setFlashdata('success', 'Successfully enrolled in ' . ($course['title'] ?? 'course') . '.');

            // Also return course info for client-side use
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully enrolled',
                'course'  => [
                    'id' => $courseId,
                    'title' => $course['title'] ?? '',
                    'description' => $course['description'] ?? ''
                ]
            ]);
        }

        return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                           ->setJSON(['success' => false, 'message' => 'Failed to enroll']);
    }
}