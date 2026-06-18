<?php
/**
 * Test violations create page
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/core/BaseModel.php';
require_once __DIR__ . '/app/core/BaseController.php';

try {
    echo "🧪 Testing Violations Create Page\n";
    echo str_repeat("=", 60) . "\n\n";
    
    // Test 1: Check if ViolationController exists
    echo "1️⃣ Checking ViolationController...\n";
    require_once __DIR__ . '/app/models/Models.php';
    require_once __DIR__ . '/app/services/ViolationService.php';
    require_once __DIR__ . '/app/controllers/ViolationController.php';
    
    if (class_exists('ViolationController')) {
        echo "   ✅ ViolationController class exists\n\n";
    } else {
        echo "   ❌ ViolationController class not found\n";
        exit(1);
    }
    
    // Test 2: Check if create method exists
    echo "2️⃣ Checking create method...\n";
    $reflection = new ReflectionClass('ViolationController');
    if ($reflection->hasMethod('create')) {
        echo "   ✅ create() method exists\n\n";
    } else {
        echo "   ❌ create() method not found\n";
        exit(1);
    }
    
    // Test 3: Check students query
    echo "3️⃣ Testing students query...\n";
    $db = Database::getInstance();
    $students = $db->select(
        "SELECT s.id, s.full_name, s.student_code
         FROM students s
         ORDER BY s.full_name"
    );
    
    if (is_array($students)) {
        echo "   ✅ Students query successful\n";
        printf("   Found %d students\n\n", count($students));
    }
    
    echo str_repeat("=", 60) . "\n";
    echo "✅ All checks passed\n";
    echo str_repeat("=", 60) . "\n";

} catch (Throwable $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: {$e->getFile()}:{$e->getLine()}\n";
    echo "\nTrace:\n";
    echo $e->getTraceAsString();
    exit(1);
}
