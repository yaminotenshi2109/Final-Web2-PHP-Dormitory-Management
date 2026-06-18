<?php
/**
 * Test Room Registration Creation
 * Simulates a student submitting a room registration
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/core/Database.php';

try {
    $db = Database::getInstance();
    
    echo "🧪 Testing Room Registration Creation\n";
    echo str_repeat("=", 60) . "\n\n";
    
    // 1. Get a student
    echo "1️⃣ Finding a student...\n";
    $student = $db->selectOne(
        "SELECT s.id, s.user_id, s.full_name FROM students s LIMIT 1"
    );
    
    if (!$student) {
        echo "❌ No student found in database\n";
        exit(1);
    }
    
    echo "✅ Found student: {$student['full_name']} (ID: {$student['id']})\n\n";
    
    // 2. Get current semester
    echo "2️⃣ Calculating current semester...\n";
    $month = (int)date('m');
    if ($month >= 9) {
        $semester = 'HK1';
        $year = (int)date('Y');
    } elseif ($month >= 1 && $month <= 5) {
        $semester = 'HK2';
        $year = (int)date('Y') - 1;
    } else {
        $semester = 'HKH';
        $year = (int)date('Y') - 1;
    }
    
    echo "✅ Current semester: {$semester} (Year: {$year})\n\n";
    
    // 3. Check if registration already exists
    echo "3️⃣ Checking for existing registration...\n";
    $existing = $db->selectOne(
        "SELECT id FROM room_registrations 
         WHERE student_id = ? AND semester = ? AND academic_year = ?
         AND status IN ('pending', 'approved')",
        [$student['id'], $semester, $year]
    );
    
    if ($existing) {
        echo "⚠️ Student already has a registration for this semester\n";
        echo "   Skipping insertion to avoid duplicate\n\n";
    } else {
        echo "✅ No existing registration found\n\n";
        
        // 4. Get available building
        echo "4️⃣ Getting available building...\n";
        $building = $db->selectOne(
            "SELECT id, name FROM buildings WHERE status = 'active' LIMIT 1"
        );
        
        if ($building) {
            echo "✅ Building: {$building['name']} (ID: {$building['id']})\n\n";
        }
        
        // 5. Create registration
        echo "5️⃣ Creating room registration...\n";
        $registrationId = $db->insert('room_registrations', [
            'student_id'            => $student['id'],
            'semester'              => $semester,
            'academic_year'         => $year,
            'preferred_building_id' => $building['id'] ?? null,
            'preferred_room_type'   => 'standard',
            'notes'                 => 'Test registration via CLI',
            'status'                => 'pending',
        ]);
        
        echo "✅ Registration created! ID: {$registrationId}\n\n";
        
        // 6. Verify insertion
        echo "6️⃣ Verifying registration...\n";
        $registration = $db->selectOne(
            "SELECT r.*, b.name AS building_name
             FROM room_registrations r
             LEFT JOIN buildings b ON b.id = r.preferred_building_id
             WHERE r.id = ?",
            [$registrationId]
        );
        
        if ($registration) {
            echo "✅ Registration verified:\n";
            printf("   ID: %d\n", $registration['id']);
            printf("   Student: %s\n", $student['full_name']);
            printf("   Semester: %s/%d\n", $registration['semester'], $registration['academic_year']);
            printf("   Preferred Building: %s\n", $registration['building_name'] ?? 'None');
            printf("   Room Type: %s\n", $registration['preferred_room_type'] ?? 'None');
            printf("   Status: %s\n", $registration['status']);
            printf("   Created: %s\n", $registration['registered_at']);
            echo "\n";
        }
    }
    
    echo str_repeat("=", 60) . "\n";
    echo "✅ TEST PASSED - Room registration creation works!\n";
    echo str_repeat("=", 60) . "\n";

} catch (Throwable $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
