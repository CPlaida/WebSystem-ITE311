<?php
/**
 * Delete Conflicting Migration File
 */

$conflictingFile = 'app/Database/Migrations/2025_01_27_000000_UpdatedUsersTable.php';

if (file_exists($conflictingFile)) {
    unlink($conflictingFile);
    echo "✅ Deleted conflicting migration: $conflictingFile\n";
} else {
    echo "❌ File not found: $conflictingFile\n";
}

echo "\n🚀 Now run: php spark migrate\n";
?>
