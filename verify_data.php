<?php

$mysqli = new mysqli('localhost', 'root', '', 'lms_plaida');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== LMS Database Verification ===\n\n";

// Check users table
echo "USERS TABLE:\n";
$result = $mysqli->query("SELECT id, username, email, first_name, last_name, role, status FROM users");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id']} | Username: {$row['username']} | Email: {$row['email']} | Name: {$row['first_name']} {$row['last_name']} | Role: {$row['role']} | Status: {$row['status']}\n";
    }
} else {
    echo "No users found\n";
}
echo "\n";

// Check courses table
echo "COURSES TABLE:\n";
$result = $mysqli->query("SELECT c.id, c.title, c.description, c.instructor_id, u.first_name, u.last_name FROM courses c JOIN users u ON c.instructor_id = u.id");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id']} | Title: {$row['title']} | Instructor: {$row['first_name']} {$row['last_name']}\n";
        echo "Description: {$row['description']}\n";
    }
} else {
    echo "No courses found\n";
}
echo "\n";

// Check enrollments table
echo "ENROLLMENTS TABLE:\n";
$result = $mysqli->query("SELECT e.id, u.username, c.title, e.enrolled_at FROM enrollments e JOIN users u ON e.user_id = u.id JOIN courses c ON e.course_id = c.id");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id']} | Student: {$row['username']} | Course: {$row['title']} | Enrolled: {$row['enrolled_at']}\n";
    }
} else {
    echo "No enrollments found\n";
}
echo "\n";

// Check table counts
echo "TABLE RECORDS COUNT:\n";
$tables = ['users', 'courses', 'enrollments', 'lessons', 'quizzes', 'submissions'];
foreach ($tables as $table) {
    $result = $mysqli->query("SELECT COUNT(*) as count FROM $table");
    $count = $result->fetch_assoc()['count'];
    echo "$table: $count records\n";
}

$mysqli->close();
echo "\n=== Verification Complete ===\n";
