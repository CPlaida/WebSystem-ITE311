<?php

$mysqli = new mysqli('localhost', 'root', '', 'lms_plaida');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "Connected to database lms_plaida\n";

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
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

if ($mysqli->query($sql) === TRUE) {
    echo "Users table created successfully\n";
} else {
    echo "Error creating users table: " . $mysqli->error . "\n";
}

// Create courses table
$sql = "CREATE TABLE IF NOT EXISTS courses (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NULL,
    instructor_id INT(11) UNSIGNED NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (instructor_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
)";

if ($mysqli->query($sql) === TRUE) {
    echo "Courses table created successfully\n";
} else {
    echo "Error creating courses table: " . $mysqli->error . "\n";
}

// Create enrollments table
$sql = "CREATE TABLE IF NOT EXISTS enrollments (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED NOT NULL,
    course_id INT(11) UNSIGNED NOT NULL,
    enrolled_at DATETIME NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE ON UPDATE CASCADE
)";

if ($mysqli->query($sql) === TRUE) {
    echo "Enrollments table created successfully\n";
} else {
    echo "Error creating enrollments table: " . $mysqli->error . "\n";
}

// Create lessons table
$sql = "CREATE TABLE IF NOT EXISTS lessons (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id INT(11) UNSIGNED NOT NULL,
    title VARCHAR(150) NOT NULL,
    content TEXT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE ON UPDATE CASCADE
)";

if ($mysqli->query($sql) === TRUE) {
    echo "Lessons table created successfully\n";
} else {
    echo "Error creating lessons table: " . $mysqli->error . "\n";
}

// Create quizzes table
$sql = "CREATE TABLE IF NOT EXISTS quizzes (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT(11) UNSIGNED NOT NULL,
    title VARCHAR(150) NOT NULL,
    questions TEXT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE ON UPDATE CASCADE
)";

if ($mysqli->query($sql) === TRUE) {
    echo "Quizzes table created successfully\n";
} else {
    echo "Error creating quizzes table: " . $mysqli->error . "\n";
}

// Create submissions table
$sql = "CREATE TABLE IF NOT EXISTS submissions (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT(11) UNSIGNED NOT NULL,
    user_id INT(11) UNSIGNED NOT NULL,
    answers TEXT NULL,
    score INT(11) NULL,
    submitted_at DATETIME NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
)";

if ($mysqli->query($sql) === TRUE) {
    echo "Submissions table created successfully\n";
} else {
    echo "Error creating submissions table: " . $mysqli->error . "\n";
}

$mysqli->close();
echo "\nAll tables created successfully!\n";
