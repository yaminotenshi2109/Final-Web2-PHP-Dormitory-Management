<?php
/**
 * Test Contract Creation
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/Models.php';

try {
    $db = Database::getInstance();
    
    echo "🧪 Testing Contract Creation\n";
    echo str_repeat("=", 60) . "\n\n";
    
    // 1. Get a pending registration
    echo "1️⃣ Finding a pending registration...\n";
    $registration = $db->selectOne(
        "SELECT r.*, s.id as student_id FROM room_registrations r 
         JOIN students s ON r.student_id = s.id 
         WHERE r.status = 'pending' LIMIT 1"
    );
    
    if (!$registration) {
        echo "⚠️ No pending registration found. Creating test data...\n";
        
        // Get any student
        $student = $db->selectOne("SELECT id FROM students LIMIT 1");
        // Get any room
        $room = $db->selectOne("SELECT id FROM rooms WHERE status = 'available' LIMIT 1");
        
        if (!$student || !$room) {
            echo "❌ Not enough test data\n";
            exit(1);
        }
        
        // Create a test registration
        $regId = $db->insert('room_registrations', [
            'student_id' => $student['id'],
            'semester' => 'HK1',
            'academic_year' => 2025,
            'status' => 'pending',
        ]);
        
        $registration = $db->selectOne(
            "SELECT r.*, s.id as student_id FROM room_registrations r 
             JOIN students s ON r.student_id = s.id 
             WHERE r.id = ?",
            [$regId]
        );
    }
    
    echo "✅ Found registration ID: {$registration['id']}\n";
    echo "   Student ID: {$registration['student_id']}\n";
    echo "   Status: {$registration['status']}\n\n";
    
    // 2. Get available room
    echo "2️⃣ Finding available room...\n";
    $room = $db->selectOne(
        "SELECT id, room_number, building_id FROM rooms WHERE status = 'available' LIMIT 1"
    );
    
    if (!$room) {
        echo "❌ No available rooms found\n";
        exit(1);
    }
    
    echo "✅ Found room: #{$room['room_number']} (ID: {$room['id']})\n\n";
    
    // 3. Create contract
    echo "3️⃣ Creating contract...\n";
    
    $contractModel = new ContractModel();
    
    $contractData = [
        'registration_id' => $registration['id'],
        'student_id' => $registration['student_id'],
        'room_id' => $room['id'],
        'start_date' => date('Y-m-d'),
        'end_date' => date('Y-m-d', strtotime('+12 months')),
        'monthly_fee' => 1200000,
        'status' => 'active',
    ];
    
    try {
        $contractId = $contractModel->createContract($contractData);
        echo "✅ Contract created! ID: {$contractId}\n\n";
        
        // 4. Verify contract
        echo "4️⃣ Verifying contract...\n";
        $contract = $db->selectOne(
            "SELECT c.*, s.full_name FROM contracts c 
             JOIN students s ON c.student_id = s.id 
             WHERE c.id = ?",
            [$contractId]
        );
        
        if ($contract) {
            echo "✅ Contract verified:\n";
            printf("   ID: %d\n", $contract['id']);
            printf("   Student: %s\n", $contract['full_name']);
            printf("   Room ID: %d\n", $contract['room_id']);
            printf("   Fee: %s VND\n", number_format($contract['monthly_fee']));
            printf("   Status: %s\n", $contract['status']);
            echo "\n";
        }
        
    } catch (Throwable $e) {
        echo "❌ Contract creation failed: " . $e->getMessage() . "\n";
        exit(1);
    }
    
    echo str_repeat("=", 60) . "\n";
    echo "✅ Contract creation test passed!\n";
    echo str_repeat("=", 60) . "\n";

} catch (Throwable $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
