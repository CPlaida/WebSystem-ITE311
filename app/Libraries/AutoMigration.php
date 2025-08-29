<?php

namespace App\Libraries;

use CodeIgniter\Database\Config;

class AutoMigration
{
    protected $db;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    public function ensureDatabase()
    {
        try {
            // Check if database exists and create if not
            $this->createDatabaseIfNotExists();
            
            // Check if essential tables exist
            if (!$this->db->tableExists('users') || !$this->db->tableExists('courses')) {
                // Tables are missing, recreate them
                return $this->recreateTablesManually();
            }
            
            // Check if tables have data, if not seed them
            $this->seedDataIfEmpty();
            
            return true;
        } catch (\Exception $e) {
            // If anything fails, use the recreation script approach
            return $this->recreateTablesManually();
        }
    }
    
    protected function createDatabaseIfNotExists()
    {
        $config = config('Database');
        $database = $config->default['database'];
        
        // Connect without database selection
        $tempConfig = $config->default;
        $tempConfig['database'] = '';
        $tempDb = new \CodeIgniter\Database\MySQLi\Connection($tempConfig);
        
        $tempDb->query("CREATE DATABASE IF NOT EXISTS `{$database}`");
        $tempDb->close();
    }
    
    protected function createMigrationsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            version VARCHAR(255) NOT NULL,
            class VARCHAR(255) NOT NULL,
            `group` VARCHAR(255) NOT NULL,
            `namespace` VARCHAR(255) NOT NULL,
            `time` INT(11) NOT NULL,
            batch INT(11) UNSIGNED NOT NULL
        )";
        
        $this->db->query($sql);
        
        // Insert migration records with correct version format
        $migrations = [
            [
                'version' => '2025_08_24_155341',
                'class' => 'App\\Database\\Migrations\\CreateUsersTable',
                'group' => 'default',
                'namespace' => 'App',
                'time' => time(),
                'batch' => 1
            ],
            [
                'version' => '2025_08_24_155403',
                'class' => 'App\\Database\\Migrations\\CreateCoursesTable',
                'group' => 'default',
                'namespace' => 'App',
                'time' => time(),
                'batch' => 1
            ],
            [
                'version' => '2025_08_24_155415',
                'class' => 'App\\Database\\Migrations\\CreateEnrollmentsTable',
                'group' => 'default',
                'namespace' => 'App',
                'time' => time(),
                'batch' => 1
            ],
            [
                'version' => '2025_08_24_155428',
                'class' => 'App\\Database\\Migrations\\CreateLessonsTable',
                'group' => 'default',
                'namespace' => 'App',
                'time' => time(),
                'batch' => 1
            ],
            [
                'version' => '2025_08_24_155439',
                'class' => 'App\\Database\\Migrations\\CreateQuizzesTable',
                'group' => 'default',
                'namespace' => 'App',
                'time' => time(),
                'batch' => 1
            ],
            [
                'version' => '2025_08_24_155450',
                'class' => 'App\\Database\\Migrations\\CreateSubmissionsTable',
                'group' => 'default',
                'namespace' => 'App',
                'time' => time(),
                'batch' => 1
            ]
        ];
        
        foreach ($migrations as $migration) {
            $this->db->table('migrations')->insert($migration);
        }
    }
    
    protected function seedDataIfEmpty()
    {
        if (!$this->db->tableExists('users')) {
            return;
        }
        
        $userCount = $this->db->table('users')->countAllResults();
        if ($userCount === 0) {
            $seeder = \Config\Database::seeder();
            $seeder->call('UserSeeder');
            $seeder->call('CourseSeeder');
        }
    }
    
    protected function recreateTablesManually()
    {
        try {
            // Drop existing tables if they exist (in reverse dependency order)
            $tables_to_drop = [
                'submissions',
                'quizzes', 
                'lessons',
                'enrollments',
                'courses',
                'users'
            ];

            foreach ($tables_to_drop as $table) {
                $this->db->query("DROP TABLE IF EXISTS $table");
            }

            // Create users table
            $sql = "CREATE TABLE users (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                first_name VARCHAR(100) NULL,
                last_name VARCHAR(100) NULL,
                role ENUM('student', 'instructor', 'admin') DEFAULT 'student',
                status ENUM('active', 'inactive') DEFAULT 'active',
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            )";
            $this->db->query($sql);

            // Create courses table
            $sql = "CREATE TABLE courses (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(200) NOT NULL,
                description TEXT NULL,
                instructor_id INT(11) UNSIGNED NOT NULL,
                status ENUM('active', 'inactive') DEFAULT 'active',
                created_at DATETIME NULL,
                updated_at DATETIME NULL,
                FOREIGN KEY (instructor_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )";
            $this->db->query($sql);

            // Create enrollments table
            $sql = "CREATE TABLE enrollments (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT(11) UNSIGNED NOT NULL,
                course_id INT(11) UNSIGNED NOT NULL,
                enrolled_at DATETIME NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE ON UPDATE CASCADE
            )";
            $this->db->query($sql);

            // Create lessons table
            $sql = "CREATE TABLE lessons (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                course_id INT(11) UNSIGNED NOT NULL,
                title VARCHAR(150) NOT NULL,
                content TEXT NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL,
                FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE ON UPDATE CASCADE
            )";
            $this->db->query($sql);

            // Create quizzes table
            $sql = "CREATE TABLE quizzes (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                lesson_id INT(11) UNSIGNED NOT NULL,
                title VARCHAR(150) NOT NULL,
                questions TEXT NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL,
                FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE ON UPDATE CASCADE
            )";
            $this->db->query($sql);

            // Create submissions table
            $sql = "CREATE TABLE submissions (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                quiz_id INT(11) UNSIGNED NOT NULL,
                user_id INT(11) UNSIGNED NOT NULL,
                answers TEXT NULL,
                score INT(11) NULL,
                submitted_at DATETIME NULL,
                FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )";
            $this->db->query($sql);
            
            // Create migrations table and populate it
            $this->createMigrationsTable();
            
            // Seed with sample data
            $this->insertSampleData();
            
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Manual table recreation failed: ' . $e->getMessage());
            return false;
        }
    }
    
    protected function insertSampleData()
    {
        // Insert sample users
        $users = [
            [
                'username' => 'plaida1',
                'email' => 'admin@lms.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'role' => 'admin',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'kent2',
                'email' => 'instructor@lms.com',
                'password' => password_hash('instructor123', PASSWORD_DEFAULT),
                'first_name' => 'Aj',
                'last_name' => 'Roquero',
                'role' => 'instructor',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'labasa3',
                'email' => 'student@lms.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'first_name' => 'Zyf',
                'last_name' => 'Diga',
                'role' => 'student',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($users as $user) {
            $this->db->table('users')->insert($user);
        }

        // Insert sample courses
        $courses = [
            [
                'title' => 'Introduction to Web Development',
                'description' => 'Learn the fundamentals of HTML, CSS, and JavaScript for building modern websites.',
                'instructor_id' => 2,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Database Management Systems',
                'description' => 'Comprehensive course on database design, SQL, and data management principles.',
                'instructor_id' => 2,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Advanced PHP Programming',
                'description' => 'Master PHP frameworks, object-oriented programming, and web application development.',
                'instructor_id' => 2,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($courses as $course) {
            $this->db->table('courses')->insert($course);
        }

        // Insert sample enrollments
        $enrollments = [
            ['user_id' => 3, 'course_id' => 1, 'enrolled_at' => date('Y-m-d H:i:s')],
            ['user_id' => 3, 'course_id' => 2, 'enrolled_at' => date('Y-m-d H:i:s')],
            ['user_id' => 3, 'course_id' => 3, 'enrolled_at' => date('Y-m-d H:i:s')]
        ];

        foreach ($enrollments as $enrollment) {
            $this->db->table('enrollments')->insert($enrollment);
        }
    }
}
