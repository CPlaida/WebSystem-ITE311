<?php

namespace App\Controllers;

use App\Models\MaterialsModel;
use App\Models\CourseModel;

class Materials extends BaseController
{
    protected $materialsModel;
    protected $courseModel;
    protected $enrollmentModel;

    public function __construct()
    {
        helper(['form', 'url']);
    // Use fully-qualified class names to avoid autoload/name resolution issues
    $this->materialsModel = new \App\Models\MaterialsModel();
    $this->courseModel = new \App\Models\CourseModel();
    $this->enrollmentModel = new \App\Models\EnrollmentModel();
    }

    public function index($course_id)
    {
        $data = [
            'course' => $this->courseModel->find($course_id),
            'materials' => $this->materialsModel->getMaterialsByCourse($course_id),
            'user' => [
                'name' => session()->get('name') ?? session()->get('username'),
                'role' => session()->get('role')
            ]
        ];

        return view('materials/list', $data);
    }

    public function student()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'student') {
            return redirect()->to('/login');
        }

        $user_id = session()->get('user_id');
        $enrolledCourses = $this->enrollmentModel->getUserEnrollments($user_id);
        
        $data = [
            'title' => 'My Course Materials',
            'user' => [
                'name' => session()->get('name') ?? session()->get('username'),
                'role' => session()->get('role')
            ],
            'enrolledCourses' => [],
            'availableCourses' => []
        ];

        foreach ($enrolledCourses as $course) {
            $materials = $this->materialsModel->getMaterialsByCourse($course['id']);
            $data['enrolledCourses'][] = [
                'course' => [
                    'id' => $course['id'],
                    'title' => $course['title'],
                    'description' => $course['description'] ?? ''
                ],
                'materials' => $materials ?? []
            ];
        }

    $allCourses = $this->courseModel->findAll();
        $data['availableCourses'] = array_values(array_filter($allCourses, function($course) use ($user_id) {
            return !$this->enrollmentModel->isAlreadyEnrolled($user_id, $course['id']);
        }));

        // Build a simple courses list for the existing materials/list view
        $courseList = array_map(function ($item) {
            return $item['course'];
        }, $data['enrolledCourses']);

        $viewData = [
            'courses' => $courseList,
            'user' => $data['user'],
        ];

        return view('materials/list', $viewData);
    }

    public function download($id)
    {
        $material = $this->materialsModel->getMaterialById($id);
        if (!$material) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Enrollment/permission check: allow admin/teacher, or enrolled student
    $userRole = session()->get('role');
    // normalize session key for user id (support both 'user_id' and legacy 'userID')
    $userId = (int) (session()->get('user_id') ?? session()->get('userID') ?? 0);
        $courseId = (int) ($material['course_id'] ?? 0);

        $allowed = in_array($userRole, ['admin','teacher']);
        if ($userRole === 'student') {
            $allowed = $this->enrollmentModel->isAlreadyEnrolled($userId, $courseId);
        }
        if (!$allowed) {
            return redirect()->back()->with('error', 'You must be enrolled in this course to download materials.');
        }

        $path = FCPATH . ($material['file_path'] ?? '');
        if (!is_file($path)) {
            return redirect()->back()->with('error', 'File not found on disk.');
        }

        return $this->response->download($path, null)->setFileName($material['file_name']);
    }

    public function delete($id)
    {
        if (!in_array(session()->get('role'), ['admin', 'teacher'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $material = $this->materialsModel->find($id);
        if ($material) {
            $path = FCPATH . ($material['file_path'] ?? '');
            if (is_file($path)) {
                @unlink($path);
            }
            $this->materialsModel->deleteMaterial($id);
            return redirect()->back()->with('success', 'Material deleted successfully.');
        }

        return redirect()->back()->with('error', 'Material not found.');
    }

    public function upload()
    {
        $file = $this->request->getFile('file');
        $course_id = $this->request->getPost('course_id');

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->with('error', 'No valid file uploaded.');
        }

        $newName = $file->getRandomName();
        $targetDir = FCPATH . 'uploads/materials';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if ($file->move($targetDir, $newName)) {
            $this->materialsModel->insertMaterial([
                'course_id' => $course_id,
                'file_name' => $file->getClientName(),
                'file_path' => 'uploads/materials/' . $newName,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to("/materials/course/{$course_id}")
                ->with('success', 'Material uploaded successfully!');
        }

        return redirect()->back()->with('error', 'Failed to upload file.');
    }

    public function uploadForm($course_id)
    {
        $data = [
            'course_id' => $course_id,
            'user' => [
                'name' => session()->get('name') ?? session()->get('username'),
                'role' => session()->get('role')
            ]
        ];

        return view('materials/upload', $data);
    }

    // NOTE: studentMaterials() removed — use student() instead which now renders the
    // enrolled courses via the existing materials/list view.
}