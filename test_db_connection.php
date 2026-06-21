<?php
/**
 * Test database connection
 */

echo "🧪 Testing Database Connection\n";
echo str_repeat("=", 60) . "\n\n";

// Check PHP PDO extensions
echo "1️⃣ Checking PHP extensions...\n";
if (extension_loaded('pdo')) {
    echo "   ✅ PDO extension loaded\n";
} else {
    echo "   ❌ PDO extension not loaded\n";
}

if (extension_loaded('pdo_mysql')) {
    echo "   ✅ PDO MySQL extension loaded\n";
} else {
    echo "   ❌ PDO MySQL extension not loaded\n";
}

echo "\n2️⃣ Attempting direct connection...\n";

try {
    $pdo = new PDO(
        'mysql:host=127.0.0.1;port=3306;dbname=ktx;charset=utf8mb4',
        'root',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    );
    echo "   ✅ Connection successful\n\n";
    
    // Test query
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM students");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "3️⃣ Testing query...\n";
    printf("   ✅ Students count: %d\n", $row['cnt']);
} catch (PDOException $e) {
    echo "   ❌ Connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "✅ Database is accessible\n";
echo str_repeat("=", 60) . "\n";
