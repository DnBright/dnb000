<?php
header('Content-Type: text/plain');

$target = __DIR__ . '/../storage/app/public';
$link = __DIR__ . '/storage';

echo "Target: $target\n";
echo "Link: $link\n\n";

// 1. Check what exists at the link path
if (file_exists($link)) {
    if (is_link($link)) {
        echo "Found existing SYMLINK. Checking target...\n";
        echo "Validating target: " . readlink($link) . "\n";
        unlink($link);
        echo "Deleted existing symlink to be safe.\n";
    } elseif (is_dir($link)) {
        echo "Found existing DIRECTORY. This is the problem!\n";
        // Try to delete it
        // valid way to delete non-empty dir in PHP
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($link, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }

        if (rmdir($link)) {
            echo "Directory 'public/storage' successfully DELETED.\n";
        } else {
            echo "FAILED to delete directory. Trying exec rm -rf...\n";
            exec("rm -rf " . escapeshellarg($link), $out, $ret);
            if ($ret === 0) echo "exec(rm -rf) success.\n";
            else echo "exec(rm -rf) failed.\n";
        }
    } else {
        echo "Found a FILE. Deleting...\n";
        unlink($link);
    }
} else {
    echo "Nothing found at 'public/storage'. Clean slate.\n";
}

// 2. Create the Symlink
echo "\nCreating Symlink...\n";
if (symlink($target, $link)) {
    echo "SUCCESS: symlink() created.\n";
} else {
    echo "PHP symlink() failed. Trying exec()...\n";
    $cmd = "ln -s " . escapeshellarg($target) . " " . escapeshellarg($link);
    exec($cmd, $out, $ret);
    if ($ret === 0) echo "exec(ln -s) success.\n";
    else echo "FAILED to create link.\n";
}

// 3. Final Verification
if (is_link($link)) {
    echo "\nVERIFICATION: public/storage is now a SYMLINK.\n";
    echo "Points to: " . readlink($link) . "\n";
    
    // Check if we can see the file we found earlier
    $testFile = $link . '/pages/SDjJVKyaFF0q71aRSKwMzpu32wk0PCTTG8ljSbij.png';
    if (file_exists($testFile)) {
         echo "TEST FILE VISIBLE! The fix worked.\n";
         echo "File: $testFile\n";
    } else {
         echo "Test file not visible yet. (Might be path issue or file doesn't exist). checking root test.txt...\n";
         if (file_exists($link . '/test.txt')) echo "Root test.txt is VISIBLE.\n";
    }
} else {
    echo "\nVERIFICATION FAILED: Still not a link.\n";
}
?>
