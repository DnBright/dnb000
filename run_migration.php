#!/usr/bin/env php
<?php
set_time_limit(300);
chdir('/Users/mac/Downloads/Darkandbright');

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n=== RUNNING MIGRATIONS ===\n\n";

$exitCode = $kernel->call('migrate:fresh', ['--no-interaction' => true]);

echo "\n=== VERIFYING RESULTS ===\n\n";

try {
    $tables = DB::table('information_schema.tables')
        ->where('table_schema', 'db_dnb')
        ->pluck('table_name')
        ->toArray();
    
    echo "✅ Connected to database\n";
    echo "📊 Tables created: " . count($tables) . "\n\n";
    
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
    
    echo "ERD Table Status:\n";
    $missing = [];
    foreach ($expected as $exp) {
        if (in_array($exp, $tables)) {
            echo "   ✅ $exp\n";
        } else {
            echo "   ❌ $exp (MISSING)\n";
            $missing[] = $exp;
        }
    }
    
    if (empty($missing)) {
        echo "\n✨ SUCCESS! All 9 ERD tables created!\n";
    } else {
        echo "\n⚠️  Missing tables: " . implode(', ', $missing) . "\n";
    }
    
} catch (Exception $e) {
    echo "Error checking tables: " . $e->getMessage() . "\n";
}

exit($exitCode);
