<?php
/**
 * Test Students Table Structure
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/core/Database.php';

try {
    $db = Database::getInstance();
    
    echo "🧪 Testing Students Table Structure\n";
    echo str_repeat("=", 60) . "\n\n";
    
    // 1. Check table structure
    echo "1️⃣ Checking students table columns...\n\n";
    $columns = $db->select("DESCRIBE students");
    
    echo "   Columns in students table:\n";
    $hasUserId = false;
    foreach ($columns as $col) {
        printf("   - %s (%s)\n", $col['Field'], $col['Type']);
        if ($col['Field'] === 'user_id') {
            $hasUserId = true;
        }
    }
    
    if ($hasUserId) {
        echo "\n   ✅ user_id column exists\n\n";
    } else {
        echo "\n   ❌ user_id column NOT FOUND\n\n";
    }
    
    // 2. Test the problematic query
    echo "2️⃣ Testing the contract query...\n\n";
    
    $result = $db->selectOne(
        "SELECT s.user_id, s.full_name FROM students s WHERE s.id = ? LIMIT 1",
        [1]
    );
    
    if ($result) {
        echo "   ✅ Query successful!\n";
        printf("   User ID: %d\n", $result['user_id']);
        printf("   Full Name: %s\n", $result['full_name']);
    } else {
        echo "   ⚠️ No student with ID 1 found\n";
    }
    
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "✅ Students table structure is correct\n";
    echo str_repeat("=", 60) . "\n";

} catch (Throwable $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
