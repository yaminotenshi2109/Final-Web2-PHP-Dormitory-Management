<?php
/**
 * test/add_student_demo.php
 * Add demo student account to database
 * Run once, then delete this file
 */

// Database connection
$dbHost = '127.0.0.1';
$dbName = 'ktx';
$dbUser = 'root';
$dbPass = '';

try {
    $conn = new PDO(
        "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // Check if student account already exists
    $existing = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $existing->execute(['student@ktx.edu.vn']);
    $existingUser = $existing->fetch();
    
    if (!$existingUser) {
        // Hash password: Student@123
        $passwordHash = password_hash('Student@123', PASSWORD_BCRYPT, ['cost' => 12]);
        
        // Insert student user account
        $stmt = $conn->prepare("
            INSERT INTO users (username, email, password_hash, role, status)
            VALUES ('student', 'student@ktx.edu.vn', ?, 'student', 'active')
        ");
        $stmt->execute([$passwordHash]);
        $userId = $conn->lastInsertId();
        
        // Insert student profile
        $stmt = $conn->prepare("
            INSERT INTO students 
            (user_id, student_code, full_name, gender, dob, faculty, program, priority_level, phone, hometown, id_card)
            VALUES (?, 'SV20250001', 'Demo Student', 'male', '2005-01-01', 'Công nghệ thông tin', 'Đại trà', 0, '0987654321', 'Thành phố Hồ Chí Minh', '001234567888')
        ");
        $stmt->execute([$userId]);
        
        echo "✅ Student demo account created successfully!\n";
        echo "   Email: student@ktx.edu.vn\n";
        echo "   Password: Student@123\n";
    } else {
        echo "ℹ️  Student account already exists.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
