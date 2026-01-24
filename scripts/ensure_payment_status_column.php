<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('orders', 'payment_status')) {
    echo "Adding payment_status column...\n";
    Schema::table('orders', function (Blueprint $table) {
        $table->string('payment_status')->default('pending')->after('status');
    });
    echo "Done.\n";
} else {
    echo "payment_status column already exists.\n";
}

// show columns
$columns = \Illuminate\Support\Facades\DB::select("SHOW COLUMNS FROM orders");
foreach ($columns as $c) {
    echo $c->Field . "\n";
}
