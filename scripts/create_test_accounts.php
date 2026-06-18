<?php
require_once __DIR__ . '/../app/core/Database.php';
$db = Database::getInstance();

// Admin test account
$adminUser = $db->selectOne("SELECT id FROM users WHERE username = ?", ['admin_test']);
$adminData = [
    'username' => 'admin_test',
    'email' => 'admin@test.com',
    'password_hash' => password_hash('Admin123!', PASSWORD_BCRYPT, ['cost' => 12]),
    'role' => 'admin',
    'status' => 'active'
];

if ($adminUser) {
    $db->update('users', $adminData, 'id = ?', [$adminUser['id']]);
    echo "Admin test account updated.\n";
} else {
    $db->insert('users', $adminData);
    echo "Admin test account created.\n";
}

// Student test account
$studentUser = $db->selectOne("SELECT id FROM users WHERE username = ?", ['student_test']);
$studentData = [
    'username' => 'student_test',
    'email' => 'student@test.com',
    'password_hash' => password_hash('Student123!', PASSWORD_BCRYPT, ['cost' => 12]),
    'role' => 'student',
    'status' => 'active'
];

if ($studentUser) {
    $db->update('users', $studentData, 'id = ?', [$studentUser['id']]);
    $studentUserId = $studentUser['id'];
    echo "Student test account updated.\n";
} else {
    $studentUserId = $db->insert('users', $studentData);
    echo "Student test account created.\n";
}

// Student profile
$studentProfile = $db->selectOne("SELECT id FROM students WHERE user_id = ?", [$studentUserId]);
$studentProfileData = [
    'user_id' => $studentUserId,
    'student_code' => 'SVTEST001',
    'full_name' => 'Test Student',
    'gender' => 'male',
    'dob' => '2000-01-01',
    'faculty' => 'Khoa Công nghệ',
    'program' => 'Chất lượng cao',
    'priority_level' => 0,
    'phone' => '0900000000',
    'hometown' => 'Hà Nội',
    'id_card' => '000000000000'
];

if ($studentProfile) {
    $db->update('students', $studentProfileData, 'id = ?', [$studentProfile['id']]);
    echo "Student test profile updated.\n";
} else {
    $db->insert('students', $studentProfileData);
    echo "Student test profile created.\n";
}

echo "All test accounts/profiles are set up successfully.\n";
?>
