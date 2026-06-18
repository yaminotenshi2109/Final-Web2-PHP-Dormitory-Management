<?php
/**
 * Test Admin Registrations Query
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/core/Database.php';

try {
    $db = Database::getInstance();
    
    echo "🧪 Testing Admin Registrations Query\n";
    echo str_repeat("=", 60) . "\n\n";
    
    // Test the exact query from RegistrationController::index
    $where = "1";
    $args = [];
    
    // Simulate with status filter
    $status = 'pending';
    $where .= " AND r.status = ?";
    $args[] = $status;
    
    echo "1️⃣ Testing query with pending status filter...\n\n";
    
    $result = $db->select(
        "SELECT r.*, s.full_name, s.gender, s.priority_level,
                b.name AS building_name,
                rm.room_number, rm.floor
         FROM room_registrations r
         JOIN students s ON s.id = r.student_id
         LEFT JOIN buildings b ON b.id = r.preferred_building_id
         LEFT JOIN rooms rm ON rm.id = r.room_id OR rm.id = r.assigned_room_id
         WHERE {$where}
         ORDER BY r.registered_at DESC
         LIMIT 5",
        $args
    );
    
    if (empty($result)) {
        echo "⚠️ No pending registrations found\n";
    } else {
        echo "✅ Query successful! Found " . count($result) . " registrations:\n\n";
        foreach ($result as $i => $reg) {
            echo sprintf(
                "  %d. %s (ID: %d, Status: %s, Building: %s)\n",
                $i + 1,
                $reg['full_name'],
                $reg['id'],
                $reg['status'],
                $reg['building_name'] ?? 'N/A'
            );
        }
    }
    
    echo "\n" . str_repeat("=", 60) . "\n";
    
    // Test the show query
    echo "\n2️⃣ Testing show query...\n\n";
    
    $id = 1;
    $registration = $db->selectOne("
        SELECT r.*, s.full_name, s.student_code, s.gender, s.priority_level, s.phone,
               b.name AS building_name,
               rm.room_number, rm.floor
        FROM room_registrations r
        JOIN students s ON s.id = r.student_id
        LEFT JOIN buildings b ON b.id = r.preferred_building_id
        LEFT JOIN rooms rm ON rm.id = r.room_id OR rm.id = r.assigned_room_id
        WHERE r.id = ?
    ", [$id]);
    
    if ($registration) {
        echo "✅ Show query successful!\n";
        printf("   ID: %d\n", $registration['id']);
        printf("   Student: %s\n", $registration['full_name']);
        printf("   Status: %s\n", $registration['status']);
        printf("   Building: %s\n", $registration['building_name'] ?? 'N/A');
        printf("   Room: %s\n", $registration['room_number'] ? "#{$registration['room_number']}" : 'Not assigned');
    } else {
        echo "⚠️ Registration not found\n";
    }
    
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "✅ ALL TESTS PASSED - Admin registrations queries work!\n";
    echo str_repeat("=", 60) . "\n";

} catch (Throwable $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
