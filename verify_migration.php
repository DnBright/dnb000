#!/usr/bin/env php
<?php
chdir('/Users/mac/Downloads/Darkandbright');
require 'vendor/autoload.php';
require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $tables = DB::table('information_schema.tables')
        ->where('table_schema', '=', 'db_dnb')
        ->pluck('table_name')
        ->toArray();
    
    echo "\n=== DATABASE VERIFICATION ===\n\n";
    echo "✅ Connected to database: db_dnb\n\n";
    echo "📋 Tables found (" . count($tables) . " total):\n";
    
    foreach ($tables as $table) {
        echo "   ✓ $table\n";
    }
    
    echo "\n=== EXPECTED ERD TABLES ===\n";
    $expected = [
        'designpackage',
        'users',
        'order',
        'payment',
        'chatlog',
        'revision',
        'finalfile',
        'guaranteeclaim',
        'adminreport'
    ];
    
    foreach ($expected as $expected_table) {
        if (in_array($expected_table, $tables)) {
            echo "   ✅ $expected_table\n";
        } else {
            echo "   ❌ $expected_table (MISSING)\n";
        }
    }
    
    echo "\n=== TABLE STRUCTURES ===\n\n";
    
    // Check order table structure
    $orderColumns = DB::getSchemaBuilder()->getColumnListing('order');
    echo "order table columns:\n";
    foreach ($orderColumns as $col) {
        echo "   - $col\n";
    }
    
    echo "\nMigration verification complete!\n\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
