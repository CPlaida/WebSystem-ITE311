<?php
/**
 * Fix Migration Conflict Script
 * This script resolves the duplicate column name error by resetting migrations
 */

// Database connection settings (update these to match your database)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'lms_plaida';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🔧 Starting migration conflict fix...\n";
    
    // Step 1: Drop and recreate database
    echo "📦 Recreating database...\n";
    $pdo->exec("DROP DATABASE IF EXISTS `$database`");
    $pdo->exec("CREATE DATABASE `$database`");
    $pdo->exec("USE `$database`");
    
    echo "✅ Database recreated successfully!\n";
    echo "\n";
    echo "🚀 Next steps:\n";
    echo "1. Run: php spark migrate\n";
    echo "2. Run: php spark db:seed UserSeeder (if you have a seeder)\n";
    echo "3. Test your application with: php spark serve\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\n";
    echo "💡 Alternative solution:\n";
    echo "1. Run: php spark migrate:rollback\n";
    echo "2. Run: php spark migrate:rollback (repeat until all migrations are rolled back)\n";
    echo "3. Run: php spark migrate\n";
}
?>
