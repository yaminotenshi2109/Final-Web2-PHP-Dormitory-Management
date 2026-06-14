<?php
// Debug script to test registration controller

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/BaseModel.php';
require_once __DIR__ . '/../app/core/BaseController.php';
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/models/Models.php';
require_once __DIR__ . '/../app/services/RoomAllocationService.php';
require_once __DIR__ . '/../app/controllers/RegistrationController.php';
require_once __DIR__ . '/../middleware/Middleware.php';

// Start session
session_start();

// Simulate student login
$_SESSION['_auth_user'] = [
    'id' => 5,  // Correct user_id from the database
    'email' => 'student@ktx.edu.vn',
    'role' => 'student',
    'name' => 'Demo Student'
];

try {
    $controller = new RegistrationController();
    
    // Check if studentList method exists
    if (method_exists($controller, 'studentList')) {
        echo "✅ studentList() method exists\n";
    } else {
        echo "❌ studentList() method NOT found\n";
    }
    
    // Check if studentCreate method exists
    if (method_exists($controller, 'studentCreate')) {
        echo "✅ studentCreate() method exists\n";
    } else {
        echo "❌ studentCreate() method NOT found\n";
    }
    
    // Check if studentStore method exists
    if (method_exists($controller, 'studentStore')) {
        echo "✅ studentStore() method exists\n";
    } else {
        echo "❌ studentStore() method NOT found\n";
    }
    
    // Check if studentCancel method exists
    if (method_exists($controller, 'studentCancel')) {
        echo "✅ studentCancel() method exists\n";
    } else {
        echo "❌ studentCancel() method NOT found\n";
    }
    
    echo "\n=== Testing studentList() method ===\n";
    
    // Try to call studentList
    $controller->studentList([]);
    echo "✅ studentList() executed successfully\n";
    
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
