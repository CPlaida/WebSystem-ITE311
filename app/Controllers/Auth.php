<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    // REGISTER FUNCTION
    public function register()
    {
        $session = session(); // start session
        
        // If user already logged in, go to dashboard
        if ($session->get('userID')) {
            return redirect()->to('/dashboard');
        }

        // If form submitted
        if ($this->request->getMethod() === 'POST') {
            // Get register rules
            $rules = $this->getRegisterRules();

            // If validation fails, show errors
            if (!$this->validate($rules)) {
                return view('auth/register', ['validation' => $this->validator]);
            }

            // Get input values
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            // Default role is student if not chosen
            $role = $this->request->getPost('role') ?: 'student';

            // Data array to save in DB
            $data = [
                'username' => $username,
                'email' => $email,
                'password'   => password_hash($password, PASSWORD_DEFAULT), // encrypt password
                'role' => $role,
            ];

            // Call model to save user
            $userModel = new UserModel();
            if ($userModel->createUser($data)) {
                // If success
                $session->setFlashdata('success', 'Registration successful! Please login.');
                return redirect()->to('/login');
            } else {
                // If fail
                $session->setFlashdata('error', 'Registration failed. Please try again.');
            }
        }

        // Show register form
        return view('auth/register');
    }

    // LOGIN FUNCTION
    public function login()
    {
        $session = session(); // start session
        
        // If already logged in, go to dashboard
        if ($session->get('userID')) {
            return redirect()->to('/dashboard');
        }

        // If form submitted
        if ($this->request->getMethod() === 'POST') {
            // Get login rules
            $rules = $this->getLoginRules();

            // If validation fails, show errors
            if (!$this->validate($rules)) {
                return view('auth/login', ['validation' => $this->validator]);
            }

            // Get input values
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Find user by email
            $userModel = new UserModel();
            $user = $userModel->findByEmail($email);

            // If user exists and password matches
            if ($user && password_verify($password, $user['password'])) {
                // Save user data in session
                $this->setAuthSession($user);
                // Redirect by role
                return $this->redirectToRoleDashboard($user['role']);
            } else {
                // Wrong login details
                $session->setFlashdata('error', 'Invalid email or password.');
            }
        }

        // Show login form
        return view('auth/login');
    }

    // LOGOUT FUNCTION
    public function logout()
    {
        $session = session();
        // Remove only login data
        $session->remove(['userID', 'username', 'name', 'email', 'role', 'isLoggedIn']);
       
        // Show logout message
        $session->setFlashdata('success', 'You have been logged out successfully.');
        return redirect()->to('/login');
    }

    // DASHBOARD FUNCTION
    public function dashboard()
    {
        $session = session();
        
        // If not logged in, redirect to login
        if (!$session->get('userID')) {
            $session->setFlashdata('error', 'Please login to access the dashboard.');
            return redirect()->to('/login');
        }

        // Pass session data to dashboard view
        $data = [
            'user' => [
                'id' => $session->get('userID'),
                'username' => $session->get('username'),
                'email' => $session->get('email'),
                'role' => $session->get('role')
            ]
        ];

        return view('auth/dashboard', $data);
    }

    // HELPER: rules for register form
    private function getRegisterRules()
    {
        return [
            'username' => 'required|min_length[2]|max_length[100]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            // role is optional; if given, must be admin/teacher/student
            'role' => 'permit_empty|in_list[admin,teacher,student]',
        ];
    }

    // HELPER: rules for login form
    private function getLoginRules()
    {
        return [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];
    }

    // HELPER: save user session
    private function setAuthSession(array $user)
    {
        session()->set([
            'userID' => $user['id'],
            'username' => $user['username'],
            'email'  => $user['email'],
            'role'   => $user['role'],
            'isLoggedIn' => true,
        ]);
        session()->regenerate(); // prevent session hijacking
    }

    // HELPER: redirect user to dashboard
    private function redirectToRoleDashboard(string $role)
    {
        return redirect()->to(base_url('dashboard'));
    }
}
