<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/core/Database.php';

$db = Database::getInstance();

echo "=== room_registrations table columns ===\n\n";

$columns = $db->select("DESCRIBE room_registrations");

foreach ($columns as $col) {
    echo $col['Field'] . " (" . $col['Type'] . ")" . ($col['Key'] === 'PRI' ? " [PRIMARY KEY]" : "") . "\n";
}
