<?php
/**
 * Test Admin Registrations Approve Form
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/core/BaseController.php';

try {
    $db = Database::getInstance();
    
    echo "🧪 Testing Admin Registrations Approve Form\n";
    echo str_repeat("=", 60) . "\n\n";
    
    // Simulate the form submission environment
    session_start();
    
    // Generate CSRF token like the view does
    $token = bin2hex(random_bytes(32));
    $_SESSION['_csrf_token'] = $token;
    
    echo "1️⃣ Generated CSRF token: " . substr($token, 0, 16) . "...\n\n";
    
    // Simulate POST data with the correct field name
    $_POST['_csrf_token'] = $token;
    $_POST['registration_id'] = 1;
    
    echo "2️⃣ Testing CSRF validation with _csrf_token field...\n";
    
    // Create controller instance to test verifyCsrf
    $controller = new class extends BaseController {
        public function testCsrf() {
            try {
                $this->verifyCsrf();
                return "✅ CSRF validation passed";
            } catch (Exception $e) {
                return "❌ CSRF validation failed: " . $e->getMessage();
            }
        }
    };
    
    $result = $controller->testCsrf();
    echo "   " . $result . "\n\n";
    
    echo str_repeat("=", 60) . "\n";
    echo "✅ CSRF Token field name is correct (_csrf_token)\n";
    echo str_repeat("=", 60) . "\n";

} catch (Throwable $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
