<?php

$mysqli = new mysqli('localhost', 'root', '', 'lms_plaida');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== LMS Database Tables Check ===\n\n";

// Show all tables
echo "ALL TABLES IN DATABASE:\n";
$result = $mysqli->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    echo "- {$row[0]}\n";
}
echo "\n";

// Check each table for data
$tables = ['users', 'courses', 'enrollments', 'lessons', 'quizzes', 'submissions'];

foreach ($tables as $table) {
    echo "TABLE: $table\n";
    $result = $mysqli->query("SELECT COUNT(*) as count FROM $table");
    $count = $result->fetch_assoc()['count'];
    echo "Records: $count\n";
    
    if ($count > 0) {
        $data = $mysqli->query("SELECT * FROM $table LIMIT 3");
        while ($row = $data->fetch_assoc()) {
            echo "  - " . json_encode($row) . "\n";
        }
    }
    echo "\n";
}

$mysqli->close();
