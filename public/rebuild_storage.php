<?php
// public/rebuild_storage.php

echo "<h1>Rebuilding Storage...</h1>";

$folders = [
    '../storage',
    '../storage/app',
    '../storage/app/public', // This is what was missing!
    '../storage/framework',
    '../storage/framework/cache',
    '../storage/framework/sessions',
    '../storage/framework/views',
];

$errors = 0;

foreach ($folders as $folder) {
    $path = __DIR__ . '/' . $folder;
    if (!file_exists($path)) {
        if (mkdir($path, 0755, true)) {
            echo "✅ Created: $folder<br>";
        } else {
            echo "❌ FAILED to create: $folder<br>";
            $errors++;
        }
    } else {
        echo "ℹ️ Exists: $folder<br>";
    }
    @chmod($path, 0755);
}

// Create a dummy file to prove it works
file_put_contents(__DIR__ . '/../storage/app/public/test.txt', 'Hello, this is a test file.');
echo "<br>Created test file checking... ";
if (file_exists(__DIR__ . '/../storage/app/public/test.txt')) {
    echo "<b>OK!</b><br>";
} else {
    echo "<b>FAILED!</b><br>";
}

echo "<hr>";
if ($errors == 0) {
    echo "<h3>SUCCESS: Folder `storage/app/public` is restored.</h3>";
    echo "Now you can run the Cron Job `storage:link`.";
} else {
    echo "<h3>ERROR: Some folders could not be created.</h3>";
}
