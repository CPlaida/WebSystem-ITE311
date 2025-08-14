<?php

// Test script to verify database tables
try {
    // Create a simple database connection
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    
    $mysqli = new mysqli($hostname, $username, $password);
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    echo "MySQL connection successful!\n\n";
    
    // Show all databases
    echo "Available databases:\n";
    $result = $mysqli->query("SHOW DATABASES");
    while ($row = $result->fetch_assoc()) {
        echo "- {$row['Database']}\n";
    }
    echo "\n";
    
    // Check if lms_plaida database exists
    $result = $mysqli->query("SHOW DATABASES LIKE 'lms_plaida'");
    if ($result->num_rows > 0) {
        echo "✓ Database 'lms_plaida' exists\n\n";
        
        // Connect to the specific database
        $mysqli->select_db('lms_plaida');
        
        // Check if tables exist
        $tables = ['users', 'courses', 'enrollments', 'lessons', 'quizzes', 'submissions'];
        
        foreach ($tables as $table) {
            $result = $mysqli->query("SHOW TABLES LIKE '$table'");
            if ($result->num_rows > 0) {
                echo "✓ Table '$table' exists\n";
                
                // Show table structure
                $structure = $mysqli->query("DESCRIBE $table");
                echo "  Columns:\n";
                while ($column = $structure->fetch_assoc()) {
                    echo "    - {$column['Field']}: {$column['Type']}\n";
                }
                echo "\n";
            } else {
                echo "✗ Table '$table' does not exist\n";
            }
        }
        
        // Check data in users table
        $result = $mysqli->query("SELECT COUNT(*) as count FROM users");
        if ($result) {
            $users = $result->fetch_assoc();
            echo "Users table has {$users['count']} records\n";
        }
        
        // Check data in courses table
        $result = $mysqli->query("SELECT COUNT(*) as count FROM courses");
        if ($result) {
            $courses = $result->fetch_assoc();
            echo "Courses table has {$courses['count']} records\n";
        }
        
        // Check data in enrollments table
        $result = $mysqli->query("SELECT COUNT(*) as count FROM enrollments");
        if ($result) {
            $enrollments = $result->fetch_assoc();
            echo "Enrollments table has {$enrollments['count']} records\n";
        }
        
    } else {
        echo "✗ Database 'lms_plaida' does not exist\n";
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
