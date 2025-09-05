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
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $passwordConfirm = $this->request->getPost('password_confirm');
            
            // Validation rules
            $validation = \Config\Services::validation();
            $validation->setRules([
                'username' => 'required|min_length[2]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]'
            ]);
            
            if ($validation->withRequest($this->request)->run()) {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Save user data
                $db = \Config\Database::connect();
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'role' => 'user',
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
                    // Create session
                    $sessionData = [
                        'id' => $user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'role' => $user->role,
                        'isLoggedIn' => true
                    ];
                    
                    session()->set($sessionData);
                    session()->setFlashdata('success', 'Welcome back, ' . $user->username . '!');
                    
                    // Both user and admin go to the same dashboard
                    return redirect()->to('/dashboard');
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

    // Dashboard - unified for both user and admin
    public function dashboard()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please login first.');
            return redirect()->to('/login');
        }

        // Get user data for dashboard
        $data = [
            'username' => session()->get('username'),
            'email' => session()->get('email'),
            'role' => session()->get('role')
        ];
        
        return view('dashboard', $data);
    }

    // Keep admin dashboard method for backward compatibility
    public function adminDashboard()
    {
        return $this->dashboard();
    }
}
