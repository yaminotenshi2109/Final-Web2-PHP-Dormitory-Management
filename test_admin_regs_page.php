<?php
/**
 * Test Admin Registrations Page
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/core/Database.php';

try {
    echo "🧪 Testing Admin Registrations Page\n";
    echo str_repeat("=", 60) . "\n\n";
    
    // Simulate the RegistrationController::index method
    $db = Database::getInstance();
    
    echo "1️⃣ Testing paginate query...\n\n";
    
    $where = '1';
    $args = [];
    
    try {
        $result = $db->paginate(
            "SELECT r.*, s.full_name, s.gender, s.priority_level,
                    b.name AS building_name,
                    rm.room_number, rm.floor
             FROM room_registrations r
             JOIN students s ON s.id = r.student_id
             LEFT JOIN buildings b ON b.id = r.preferred_building_id
             LEFT JOIN rooms rm ON rm.id = r.room_id OR rm.id = r.assigned_room_id
             WHERE {$where}
             ORDER BY r.registered_at DESC",
            $args,
            1,
            10
        );
        
        if ($result) {
            echo "✅ Query successful!\n";
            printf("   Found %d registrations\n", count($result['data']));
            printf("   Total: %d\n", $result['total']);
        }
    } catch (Throwable $e) {
        echo "❌ Query failed: " . $e->getMessage() . "\n";
        exit(1);
    }
    
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "✅ Admin registrations page works\n";
    echo str_repeat("=", 60) . "\n";

} catch (Throwable $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
