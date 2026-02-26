<?php
// public/debug_storage.php

echo "<h1>Storage Debugger</h1>";

$target = realpath(__DIR__ . '/../storage/app/public');
$link = __DIR__ . '/storage';

echo "<h2>1. Checking Source Folder (storage/app/public)</h2>";
if (file_exists($target)) {
    echo "STATUS: <b>FOUND</b><br>";
    echo "Path: $target<br>";
    echo "Permissions: " . substr(sprintf('%o', fileperms($target)), -4) . "<br>";
    
    $files = scandir($target);
    $count = count($files) - 2; // remove . and ..
    echo "Files inside: $count file(s)<br>";
    
    if ($count > 0) {
        echo "Sample files: " . implode(', ', array_slice($files, 2, 5)) . "<br>";
    } else {
        echo "<b style='color:red'>WARNING: Folder is empty! Did you lose your files?</b><br>";
    }
} else {
    echo "<b style='color:red'>CRITICAL: Source folder does not exist!</b><br>";
    echo "Expected at: " . __DIR__ . '/../storage/app/public';
}

echo "<h2>2. Checking Public Link (public/storage)</h2>";
if (file_exists($link)) {
    echo "STATUS: <b>EXISTS</b><br>";
    if (is_link($link)) {
        echo "Type: <b>SYMLINK</b> (Correct Type)<br>";
        echo "Target: " . readlink($link) . "<br>";
        if (readlink($link) == $target) {
            echo "<b style='color:green'>VERDICT: Symlink is CORRECT.</b><br>";
        } else {
            echo "<b style='color:red'>VERDICT: Symlink points to wrong location.</b><br>";
        }
    } else {
        echo "Type: <b>DIRECTORY</b> (WRONG TYPE)<br>";
        echo "<b style='color:red'>VERDICT: You have a real folder named 'storage' blocking the link. DELETE IT.</b><br>";
    }
} else {
    echo "STATUS: <b>MISSING</b><br>";
    echo "Verdict: The link has not been created yet.<br>";
}

echo "<h2>3. Server User Info</h2>";
echo "User: " . get_current_user() . "<br>";
echo "PHP User: " . exec('whoami') . "<br>";
