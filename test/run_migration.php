<?php
/**
 * Database Migration Runner
 * Executes the fix_room_registrations_schema.sql migration
 */

require_once __DIR__ . '/config/config.php';

try {
    // Create PDO connection
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        DB_HOST, DB_PORT, DB_NAME, DB_CHARSET
    );
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // Read migration file
    $migrationFile = __DIR__ . '/migrations/fix_room_registrations_schema.sql';
    if (!file_exists($migrationFile)) {
        echo "❌ Migration file not found: {$migrationFile}\n";
        exit(1);
    }

    $sql = file_get_contents($migrationFile);
    
    // Execute each statement separately
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    $successCount = 0;
    $errorCount = 0;

    foreach ($statements as $statement) {
        // Skip comments and empty statements
        if (empty($statement) || str_starts_with(trim($statement), '--')) {
            continue;
        }

        try {
            $pdo->exec($statement);
            $successCount++;
            echo "✅ Executed: " . substr($statement, 0, 60) . "...\n";
        } catch (PDOException $e) {
            $errorCount++;
            echo "❌ Error: " . $e->getMessage() . "\n";
            echo "   SQL: " . substr($statement, 0, 80) . "\n\n";
        }
    }

    echo "\n" . str_repeat("=", 60) . "\n";
    echo "Migration Summary:\n";
    echo "✅ Successful: {$successCount}\n";
    echo "❌ Errors: {$errorCount}\n";
    echo str_repeat("=", 60) . "\n";

    if ($errorCount === 0) {
        echo "\n✅ Migration completed successfully!\n";
        
        // Verify schema
        echo "\n📋 Table structure after migration:\n";
        $result = $pdo->query("DESCRIBE room_registrations");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            printf("  %-25s | %-20s | %-10s\n", 
                $row['Field'], $row['Type'], $row['Null']);
        }
    } else {
        echo "\n⚠️ Migration completed with errors. Please review above.\n";
    }

    exit($errorCount > 0 ? 1 : 0);

} catch (Exception $e) {
    echo "❌ Fatal error: " . $e->getMessage() . "\n";
    exit(1);
}
