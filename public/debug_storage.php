<?php
// Turn on error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Storage Debugger</h1>";

// 1. Check if public/storage symlink exists
$linkPath = __DIR__ . '/storage';
echo "<strong>Checking Symlink at:</strong> $linkPath<br>";

if (file_exists($linkPath)) {
    echo "Status: EXISTS<br>";
} else {
    echo "Status: <span style='color:red'>MISSING</span><br>";
}

if (is_link($linkPath)) {
    echo "Type: SYMLINK<br>";
    echo "Target: " . readlink($linkPath) . "<br>";
} else {
    echo "Type: <span style='color:red'>NOT A SYMLINK (Maybe a real directory?)</span><br>";
}

// 2. Check the actual storage directory
$subDir = 'pages'; // where we upload
$targetStoragePath = dirname(__DIR__) . '/storage/app/public';
echo "<hr><strong>Checking Real Storage Path:</strong> $targetStoragePath<br>";

if (is_dir($targetStoragePath)) {
    echo "Storage App Public: EXISTS<br>";
    echo "Permissions: " . substr(sprintf('%o', fileperms($targetStoragePath)), -4) . "<br>";
    
    $pagesPath = $targetStoragePath . '/' . $subDir;
    if (is_dir($pagesPath)) {
        echo "Pages Subfolder: EXISTS<br>";
        $files = scandir($pagesPath);
        echo "Files in '$subDir':<pre>";
        print_r($files);
        echo "</pre>";
    } else {
        echo "Pages Subfolder: MISSING<br>";
    }
} else {
    echo "<span style='color:red'>CRITICAL: storage/app/public directory not found!</span><br>";
}

// 3. Test symlink traversability
echo "<hr><strong>Traversing Symlink:</strong><br>";
$testScan = scandir($linkPath);
if ($testScan) {
    echo "Successfully scanned public/storage via symlink. Contents:<br>";
    // limit output
    echo implode(', ', array_slice($testScan, 0, 10));
} else {
    echo "<span style='color:red'>FAILED to scan public/storage. Broken link or permission denied.</span>";
}
