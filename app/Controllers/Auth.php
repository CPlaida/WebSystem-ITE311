<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    // Register new user
    public function register()
    {
        // If form is submitted
        if ($this->request->getMethod() === 'POST') {
            
            // Get form data
            $lastname = $this->request->getPost('lastname');
            $firstname = $this->request->getPost('firstname');
            $middlename = $this->request->getPost('middlename');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $passwordConfirm = $this->request->getPost('password_confirm');
            $role = $this->request->getPost('role');
            
            // Validation rules
            $validation = \Config\Services::validation();
            $validation->setRules([
                'lastname' => 'required|min_length[2]|max_length[100]',
                'firstname' => 'required|min_length[2]|max_length[100]',
                'middlename' => 'max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]',
                'role' => 'required|in_list[Student,Instructor,Admin]'
            ]);
            
            if ($validation->withRequest($this->request)->run()) {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Save user data
                $db = \Config\Database::connect();
                $data = [
                    'lastname' => $lastname,
                    'firstname' => $firstname,
                    'middlename' => $middlename,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'role' => $role,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                if ($db->table('users')->insert($data)) {
                    session()->setFlashdata('success', 'Registration successful! Please login.');
                    return redirect()->to('/login');
                } else {
                    session()->setFlashdata('error', 'Registration failed. Please try again.');
                }
            } else {
                session()->setFlashdata('errors', $validation->getErrors());
            }
        }
        
        return view('register');
    }

    // Login user
    public function login()
    {
        // If form is submitted
        if ($this->request->getMethod() === 'POST') {
            
            // Get form data
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            
            // Validation rules
            $validation = \Config\Services::validation();
            $validation->setRules([
                'email' => 'required|valid_email',
                'password' => 'required'
            ]);
            
            if ($validation->withRequest($this->request)->run()) {
                // Check user in database
                $db = \Config\Database::connect();
                $user = $db->table('users')->where('email', $email)->get()->getRow();
                
                // Verify password
                if ($user && password_verify($password, $user->password)) {
                    // Create full name for session
                    $fullName = trim($user->firstname . ' ' . ($user->middlename ? $user->middlename . ' ' : '') . $user->lastname);
                    
                    // Create session
                    $sessionData = [
                        'id' => $user->id,
                        'lastname' => $user->lastname,
                        'firstname' => $user->firstname,
                        'middlename' => $user->middlename,
                        'fullname' => $fullName,
                        'email' => $user->email,
                        'role' => $user->role,
                        'isLoggedIn' => true
                    ];
                    
                    session()->set($sessionData);
                    session()->setFlashdata('success', 'Welcome back, ' . $fullName . '!');
                    
                    // Role-based dashboard redirects
                    if ($user->role == 'Student') {
                        return redirect()->to('/student-dashboard');
                    } elseif ($user->role == 'Instructor') {
                        return redirect()->to('/instructor-dashboard');
                    } elseif ($user->role == 'Admin') {
                        return redirect()->to('/admin-dashboard');
                    }
                } else {
                    session()->setFlashdata('error', 'Invalid email or password.');
                }
            } else {
                session()->setFlashdata('errors', $validation->getErrors());
            }
        }
        
        return view('login');
    }

    // Logout user
    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'You have been logged out.');
        return redirect()->to('/login');
    }

    // Dashboard - redirect based on role
    public function dashboard()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please login first.');
            return redirect()->to('/login');
        }

        // Redirect based on role
        $role = session()->get('role');
        if ($role == 'Student') {
            return redirect()->to('/student-dashboard');
        } elseif ($role == 'Instructor') {
            return redirect()->to('/instructor-dashboard');
        } elseif ($role == 'Admin') {
            return redirect()->to('/admin-dashboard');
        }
    }

    // Student Dashboard
    public function studentDashboard()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Student') {
            return redirect()->to('/login');
        }
        
        $data = [
            'lastname' => session()->get('lastname'),
            'firstname' => session()->get('firstname'),
            'middlename' => session()->get('middlename'),
            'fullname' => session()->get('fullname'),
            'email' => session()->get('email'),
            'role' => session()->get('role')
        ];
        
        return view('student_dashboard', $data);
    }
    
    // Instructor Dashboard
    public function instructorDashboard()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Instructor') {
            return redirect()->to('/login');
        }
        
        $data = [
            'lastname' => session()->get('lastname'),
            'firstname' => session()->get('firstname'),
            'middlename' => session()->get('middlename'),
            'fullname' => session()->get('fullname'),
            'email' => session()->get('email'),
            'role' => session()->get('role')
        ];
        
        return view('instructor_dashboard', $data);
    }
    
    // Admin Dashboard
    public function adminDashboard()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }
        
        $data = [
            'lastname' => session()->get('lastname'),
            'firstname' => session()->get('firstname'),
            'middlename' => session()->get('middlename'),
            'fullname' => session()->get('fullname'),
            'email' => session()->get('email'),
            'role' => session()->get('role')
        ];
        
        return view('admin_dashboard', $data);
    }
}
