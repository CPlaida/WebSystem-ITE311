<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Core table config
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Allowed fields aligned with current app flow
    protected $protectFields = true;
    protected $allowedFields = [
        'username',
        'email',
        'password',
        'role',
        'created_at',
        'updated_at',
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|min_length[2]|max_length[100]|is_unique[users.username,id,{id}]',
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        // Role may be omitted in request (defaults to student) but if provided must match enum
        'role'     => 'permit_empty|in_list[admin,teacher,student]',
    ];

    protected $validationMessages = [
        'username' => [
            'required'   => 'Username is required',
            'min_length' => 'Username must be at least 2 characters',
            'max_length' => 'Username cannot exceed 100 characters',
            'is_unique'  => 'This username is already taken',
        ],
        'email' => [
            'required'    => 'Email is required',
            'valid_email' => 'Please provide a valid email address',
            'is_unique'   => 'This email address is already registered',
        ],
        'password' => [
            'required'   => 'Password is required',
            'min_length' => 'Password must be at least 6 characters long',
        ],
        'role' => [
            'in_list' => 'Role must be admin, teacher, or student',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Do NOT hash in callbacks to avoid double-hashing — controller already hashes
    protected $allowCallbacks = false;

    /**
     * Insert a new user record.
     * Expects password to be already hashed by the controller.
     */
    public function createUser(array $data): bool
    {
        if (empty($data['role'])) {
            // Satisfy enum(admin,teacher,student) default
            $data['role'] = 'student';
        }

        // insert($data, true) returns the new ID on success, or false on failure
        $id = $this->insert($data, true);
        return $id !== false;
    }

    /**
     * Find a single user by email.
     */
    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first() ?: null;
    }

    /**
     * Optional helper: find user by username.
     */
    public function findByUsername(string $username): ?array
    {
        return $this->where('username', $username)->first() ?: null;
    }
}