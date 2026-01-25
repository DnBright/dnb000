<?php
$target = __DIR__ . '/../storage/app/public';
$shortcut = __DIR__ . '/storage';

if (file_exists($shortcut)) {
    echo "Symlink already exists. Removing it first...<br>";
    if (is_link($shortcut)) {
        unlink($shortcut);
    } elseif (is_dir($shortcut)) {
        // If it's a real directory (error), we must remove it carefully
        echo "Found a REAL DIRECTORY instead of a symlink. Please delete 'public/storage' folder manually via FTP/File Manager first.<br>";
        exit;
    }
}

if (symlink($target, $shortcut)) {
    echo "<h1 style='color:green'>SUCCESS: Symlink Created!</h1>";
    echo "Target: $target<br>";
    echo "Shortcut: $shortcut<br>";
    echo "<br>Please refresh your website content.";
} else {
    echo "<h1 style='color:red'>ERROR: Could not create symlink</h1>";
    echo "Please check permissions.";
}
