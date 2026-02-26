<?php
// public/fix_structure.php

// Helper function to create dir if not exists
function ensure_dir($path) {
    if (!file_exists($path)) {
        mkdir($path, 0755, true);
        echo "Created: $path<br>";
    } else {
        echo "Exists: $path<br>";
    }
    chmod($path, 0755);
}

echo "<h1>Fixing Storage Structure...</h1>";

$base = realpath(__DIR__ . '/../');
$storage = $base . '/storage';

echo "Base Path: $base<br>";

// Ensure main folders
ensure_dir($storage);
ensure_dir($storage . '/app');
ensure_dir($storage . '/app/public');
ensure_dir($storage . '/framework');
ensure_dir($storage . '/framework/cache');
ensure_dir($storage . '/framework/cache/data');
ensure_dir($storage . '/framework/sessions');
ensure_dir($storage . '/framework/views');
ensure_dir($storage . '/logs');
ensure_dir($base . '/bootstrap/cache');

// Fix permissions (attempt)
echo "<hr>Attempting to fix permissions...<br>";
try {
    @chmod($storage, 0775);
    @chmod($storage . '/framework', 0775);
    @chmod($storage . '/logs', 0775);
    @chmod($base . '/bootstrap/cache', 0775);
    echo "Permissions updated.<br>";
} catch (\Exception $e) {
    echo "Permission warning: " . $e->getMessage() . "<br>";
}

echo "<hr><h3>DONE!</h3> Please refresh your home page now.";
