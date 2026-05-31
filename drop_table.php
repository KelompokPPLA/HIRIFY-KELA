<?php

// Drop problematic table using Laravel DB connection bootstrap
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$db = $app->make('db');
try {
    $db->statement('DROP TABLE IF EXISTS `mentor_followers`');
    echo "Dropped table mentor_followers\n";
} catch (Exception $e) {
    echo "Error dropping table: " . $e->getMessage() . "\n";
    exit(1);
}
