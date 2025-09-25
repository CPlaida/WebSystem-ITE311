<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class Auth extends BaseController
{
    // Register new user
    public function register()
    {
        // If form is submitted
        if ($this->request->getMethod() === 'POST') {
            // Add your registration logic here (validation, saving user, etc.)
            // For now, just show the form again
        }
        return view('auth/register');
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
        
    return view('auth/login');
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
