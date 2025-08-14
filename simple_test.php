<?php

$mysqli = new mysqli('localhost', 'root', '', 'lms_plaida');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "Connected to database lms_plaida\n";

// Check for migration table
$result = $mysqli->query("SHOW TABLES LIKE 'migrations'");
if ($result->num_rows > 0) {
    echo "Migrations table exists\n";
    
    // Show migration records
    $migrations = $mysqli->query("SELECT * FROM migrations ORDER BY version");
    echo "Migration records:\n";
    while ($row = $migrations->fetch_assoc()) {
        echo "Version: {$row['version']} - Class: {$row['class']}\n";
    }
} else {
    echo "Migrations table does not exist\n";
}

// Check for our tables
$tables = ['users', 'courses', 'enrollments', 'lessons', 'quizzes', 'submissions'];
foreach ($tables as $table) {
    $result = $mysqli->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "Table $table exists\n";
    } else {
        echo "Table $table does not exist\n";
    }
}

$mysqli->close();
