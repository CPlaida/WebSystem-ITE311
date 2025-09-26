<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function register()
    {
        $session = session();
        
        // If user is already logged in, redirect to dashboard
        if ($session->get('userID')) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'POST') {
            // Set validation rules
            $rules = [
                'username' => 'required|min_length[2]|max_length[100]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]',
                // role is optional; if provided, it must be one of enum values
                'role' => 'permit_empty|in_list[admin,teacher,student]',
            ];

            if (!$this->validate($rules)) {
                return view('auth/register', ['validation' => $this->validator]);
            }

            // Get form data
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            // Default to 'student' to satisfy ENUM(admin,teacher,student)
            $role = $this->request->getPost('role') ?: 'student';


            $data = [
                'username' => $username,
                'email' => $email,
                'password'   => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $db = \Config\Database::connect();
            $builder = $db->table('users');
            if ($builder->insert($data)) {
                $session->flashdata('success', 'Registration successful! Please login.');
                return redirect()->to('/login');
            } else {
                $session->setFlashdata('error', 'Registration failed. Please try again.');
            }
        }

        return view('auth/register');
    }

    public function login()
    {
        $db = \Config\Database::connect();
        $session = session();

        // If user is already logged in, redirect to dashboard
        if ($session->get('userID')) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required'
            ];

            if (!$this->validate($rules)) {
                return view('auth/login', ['validation' => $this->validator]);
            }

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Check if user exists
            $builder = $db->table('users');
            $user = $builder->where('email', $email)->get()->getRowArray();

            if ($user && password_verify($password, $user['password'])) {
                // Set session data
                $session->set([
                    'userID' => $user['id'],
                    'username' => $user['username'],
                    // keep 'name' alias for legacy views
                    'name'   => $user['username'],
                    'email'  => $user['email'],
                    'role'   => $user['role'],
                    'isLoggedIn' => true
                ]);

                // Prevent session fixation
                session()->regenerate();

                switch ($user['role']) {
                    case 'admin':
                        return redirect()->to(base_url('admin/dashboard'));
                    case 'teacher':
                        return redirect()->to(base_url('teacher/dashboard'));
                    case 'student':
                        return redirect()->to(base_url('student/dashboard'));
                }
            } else {
                $session->setFlashdata('error', 'Invalid email or password.');
            }
        }

        return view('auth/login');
    }

    public function logout()
{
    $session = session();
    // Remove only auth-related keys so flashdata can persist
    $session->remove(['userID', 'username', 'name', 'email', 'role', 'isLoggedIn']);
    // replace
    // $session->flashdata('success', 'You have been logged out successfully.');
    // with
    $session->setFlashdata('success', 'You have been logged out successfully.');
    return redirect()->to('/login');
}

    public function dashboard()
    {
        $session = session();
        
        // Check if user is logged in
        if (!$session->get('userID')) {
            $session->setFlashdata('error', 'Please login to access the dashboard.');
            return redirect()->to('/login');
        }

        $data = [
            'user' => [
                'id' => $session->get('userID'),
                'name' => $session->get('username') ?? $session->get('name'),
                'email' => $session->get('email'),
                'role' => $session->get('role')
            ]
        ];

        return view('auth/dashboard', $data);
    }
}