<?php

$mysqli = new mysqli('localhost', 'root', '', 'lms_plaida');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== Migration Records Verification ===\n\n";

// Check migration records
$result = $mysqli->query("SELECT * FROM migrations ORDER BY id");
if ($result && $result->num_rows > 0) {
    echo "Migration records found:\n";
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id']} | Version: {$row['version']} | Class: {$row['class']} | Batch: {$row['batch']}\n";
    }
} else {
    echo "No migration records found\n";
}

echo "\n=== All Tables in Database ===\n";
$tables = $mysqli->query("SHOW TABLES");
while ($table = $tables->fetch_array()) {
    echo "- {$table[0]}\n";
}

$mysqli->close();
