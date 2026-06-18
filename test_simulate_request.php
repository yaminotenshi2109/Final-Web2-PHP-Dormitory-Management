<?php
/**
 * Simulate admin registrations request
 */

// Set up the environment like public/index.php does
ini_set('display_errors', '1');
ini_set('log_errors', '1');
error_reporting(E_ALL);

define('BASE_PATH', __DIR__);

require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/app/core/Database.php';
require_once BASE_PATH . '/app/core/BaseModel.php';
require_once BASE_PATH . '/app/core/BaseController.php';
require_once BASE_PATH . '/app/core/Router.php';
require_once BASE_PATH . '/middleware/Middleware.php';

// Include routes
require_once BASE_PATH . '/routes/web.php';

// Simulate a request for admin registrations
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/Final-Web2-PHP-Dormitory-Management/public/admin/registrations';
$_SERVER['SCRIPT_NAME'] = '/Final-Web2-PHP-Dormitory-Management/public/index.php';

// Start session
session_start();
$_SESSION['_auth_user'] = ['id' => 1, 'role' => 'admin'];
$_SESSION['_csrf_token'] = bin2hex(random_bytes(32));

try {
    echo "🧪 Simulating Admin Registrations Request\n";
    echo str_repeat("=", 60) . "\n\n";
    
    // Try to dispatch
    Router::getInstance()->dispatch();
    
    echo "\n✅ Request processed successfully\n";
} catch (Throwable $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: {$e->getFile()}:{$e->getLine()}\n";
    echo "\nTrace:\n";
    echo $e->getTraceAsString();
}
