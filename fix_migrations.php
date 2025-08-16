<?php

$mysqli = new mysqli('localhost', 'root', '', 'lms_plaida');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "Fixing migration records...\n";

// Clear existing migration records
$mysqli->query("DELETE FROM migrations");

// Insert migration records manually
$migrations = [
    [
        'version' => '20250814055648',
        'class' => 'App\\Database\\Migrations\\CreateUsersTable',
        'group' => 'default',
        'namespace' => 'App',
        'time' => time(),
        'batch' => 1
    ],
    [
        'version' => '20250814055658',
        'class' => 'App\\Database\\Migrations\\CreateCoursesTable',
        'group' => 'default',
        'namespace' => 'App',
        'time' => time(),
        'batch' => 1
    ],
    [
        'version' => '20250814055710',
        'class' => 'App\\Database\\Migrations\\CreateEnrollmentsTable',
        'group' => 'default',
        'namespace' => 'App',
        'time' => time(),
        'batch' => 1
    ],
    [
        'version' => '20250814055724',
        'class' => 'App\\Database\\Migrations\\CreateLessonsTable',
        'group' => 'default',
        'namespace' => 'App',
        'time' => time(),
        'batch' => 1
    ],
    [
        'version' => '20250814055734',
        'class' => 'App\\Database\\Migrations\\CreateQuizzesTable',
        'group' => 'default',
        'namespace' => 'App',
        'time' => time(),
        'batch' => 1
    ],
    [
        'version' => '20250814055743',
        'class' => 'App\\Database\\Migrations\\CreateSubmissionsTable',
        'group' => 'default',
        'namespace' => 'App',
        'time' => time(),
        'batch' => 1
    ]
];

foreach ($migrations as $migration) {
    $sql = "INSERT INTO migrations (version, class, `group`, namespace, time, batch) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssii", 
        $migration['version'],
        $migration['class'],
        $migration['group'],
        $migration['namespace'],
        $migration['time'],
        $migration['batch']
    );
    
    if ($stmt->execute()) {
        echo "✓ Added migration: {$migration['class']}\n";
    } else {
        echo "✗ Failed to add migration: {$migration['class']}\n";
    }
    $stmt->close();
}

echo "\nMigration records fixed! Now check phpMyAdmin.\n";
$mysqli->close();
