<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/core/Database.php';

$db = Database::getInstance();

echo "=== Checking Student Profile ===\n\n";

$user = $db->selectOne("SELECT id, email, role FROM users WHERE email = ?", ['student@ktx.edu.vn']);

if ($user) {
    echo "✅ User found:\n";
    echo "  - ID: " . $user['id'] . "\n";
    echo "  - Email: " . $user['email'] . "\n";
    echo "  - Role: " . $user['role'] . "\n";
    
    $student = $db->selectOne("SELECT id, user_id, full_name, student_code FROM students WHERE user_id = ?", [$user['id']]);
    
    if ($student) {
        echo "\n✅ Student profile found:\n";
        echo "  - Student ID: " . $student['id'] . "\n";
        echo "  - User ID: " . $student['user_id'] . "\n";
        echo "  - Full Name: " . $student['full_name'] . "\n";
        echo "  - Student Code: " . $student['student_code'] . "\n";
    } else {
        echo "\n❌ Student profile NOT found!\n";
        echo "   Need to create student profile for user_id = " . $user['id'] . "\n";
    }
} else {
    echo "❌ User not found: student@ktx.edu.vn\n";
}
