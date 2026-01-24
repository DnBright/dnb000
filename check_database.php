#!/usr/bin/env php
<?php
// Verification script - check database status

$host = '127.0.0.1';
$dbname = 'db_dnb';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "\n";
    echo "╔════════════════════════════════════════════════════════════╗\n";
    echo "║        DATABASE VERIFICATION REPORT                       ║\n";
    echo "╚════════════════════════════════════════════════════════════╝\n\n";
    
    // 1. Check connection
    echo "✅ Database Connection: OK\n";
    echo "   Host: $host\n";
    echo "   Database: $dbname\n";
    echo "   User: $user\n\n";
    
    // 2. Count total tables
    $stmt = $pdo->query("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='$dbname'");
    $totalTables = $stmt->fetchColumn();
    echo "📊 Total Tables: $totalTables\n\n";
    
    // 3. Check ERD Tables
    $expectedTables = [
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
    
    echo "🔍 ERD TABLE STATUS:\n";
    echo "─────────────────────────────────────────────\n";
    
    $allExists = true;
    foreach ($expectedTables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        $exists = $stmt->rowCount() > 0;
        
        if ($exists) {
            // Count columns
            $stmt = $pdo->query("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='$dbname' AND TABLE_NAME='$table'");
            $columnCount = $stmt->fetchColumn();
            
            // Count rows
            $stmt = $pdo->query("SELECT COUNT(*) FROM `$table`");
            $rowCount = $stmt->fetchColumn();
            
            echo "   ✅ $table\n";
            echo "      Columns: $columnCount | Rows: $rowCount\n";
        } else {
            echo "   ❌ $table (MISSING!)\n";
            $allExists = false;
        }
    }
    
    echo "\n─────────────────────────────────────────────\n\n";
    
    // 4. Check Foreign Keys
    echo "🔗 FOREIGN KEY RELATIONSHIPS:\n";
    echo "─────────────────────────────────────────────\n";
    
    $stmt = $pdo->query("
        SELECT CONSTRAINT_NAME, TABLE_NAME, REFERENCED_TABLE_NAME 
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
        WHERE TABLE_SCHEMA='$dbname' AND REFERENCED_TABLE_NAME IS NOT NULL
        ORDER BY TABLE_NAME
    ");
    
    $fkCount = 0;
    $fkRelations = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fkCount++;
        echo "   ✓ " . $row['TABLE_NAME'] . " → " . $row['REFERENCED_TABLE_NAME'] . "\n";
        $fkRelations[] = $row;
    }
    
    echo "\n   Total Foreign Keys: $fkCount\n\n";
    
    // 5. Check 'order' table specifically (had the issue)
    echo "📋 ORDER TABLE STRUCTURE:\n";
    echo "─────────────────────────────────────────────\n";
    
    $stmt = $pdo->query("DESCRIBE `order`");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $createdAtCount = 0;
    foreach ($columns as $col) {
        echo "   • {$col['Field']}: {$col['Type']}\n";
        if ($col['Field'] === 'created_at') {
            $createdAtCount++;
        }
    }
    
    echo "\n   Note: created_at appears $createdAtCount time(s) (should be 1)\n\n";
    
    // 6. Overall Status
    echo "╔════════════════════════════════════════════════════════════╗\n";
    
    if ($allExists && $fkCount >= 10 && $createdAtCount === 1) {
        echo "║              ✨ STATUS: PERFECT ✨                       ║\n";
        echo "║                                                        ║\n";
        echo "║  ✅ Semua 9 tabel ERD ada                              ║\n";
        echo "║  ✅ $fkCount foreign key relationships                       ║\n";
        echo "║  ✅ Tidak ada duplicate column                         ║\n";
        echo "║  ✅ Database siap digunakan!                           ║\n";
    } else {
        echo "║           ⚠️  STATUS: NEEDS ATTENTION ⚠️                 ║\n";
        echo "║                                                        ║\n";
        if (!$allExists) {
            echo "║  ❌ Beberapa tabel masih hilang                      ║\n";
        }
        if ($fkCount < 10) {
            echo "║  ⚠️  Foreign keys tidak lengkap ($fkCount/12)            ║\n";
        }
        if ($createdAtCount !== 1) {
            echo "║  ❌ Duplicate column pada order table                ║\n";
        }
    }
    
    echo "╚════════════════════════════════════════════════════════════╝\n\n";
    
    // 7. Sample Data
    echo "📈 SAMPLE DATA COUNT:\n";
    echo "─────────────────────────────────────────────\n";
    
    foreach ($expectedTables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) as cnt FROM `$table`");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['cnt'];
        
        $status = $count > 0 ? "📝" : "  ";
        echo "   $status $table: $count rows\n";
    }
    
    echo "\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nPastikan:\n";
    echo "  1. MySQL sedang berjalan\n";
    echo "  2. Database 'db_dnb' sudah dibuat\n";
    echo "  3. Username 'root' dan password kosong\n";
    exit(1);
}
