<?php
// Simple script to run migrations
chdir('/Users/mac/Downloads/Darkandbright');

require 'vendor/autoload.php';
require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Run migrate fresh
echo shell_exec('php artisan migrate:fresh 2>&1');
