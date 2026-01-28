<?php
// fix_all.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Ultimate Fix Script</h1>";

// 1. Try to create storage link via shell_exec
echo "Attempting to create storage link via artisan...<br>";
$output = shell_exec('cd .. && php artisan storage:link 2>&1');
echo "<pre>$output</pre>";

// 2. Clear all cache
echo "<hr>Clearing caches...<br>";
$output2 = shell_exec('cd .. && php artisan config:clear 2>&1');
echo "<pre>$output2</pre>";
$output3 = shell_exec('cd .. && php artisan cache:clear 2>&1');
echo "<pre>$output3</pre>";

// 3. Check permissions
$storagePath = __DIR__ . '/../storage';
echo "<hr>Checking permissions for: $storagePath<br>";
echo "Current perms: " . substr(sprintf('%o', fileperms($storagePath)), -4) . "<br>";

// 4. Try to fix permissions recursively if possible
echo "Attempting to set permissions 775 on storage and bootstrap/cache...<br>";
shell_exec('chmod -R 775 ../storage ../bootstrap/cache');

echo "<hr>DONE. Please check the website.";
