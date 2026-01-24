<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;

$order = Order::where(function($q){
    $q->whereNull('payment_status')->orWhere('payment_status','pending');
})->orderBy('id','desc')->first();

if (! $order) {
    echo "No pending orders found\n";
    exit(1);
}

echo json_encode(['id' => $order->id, 'amount' => (float)$order->amount], JSON_PRETTY_PRINT) . "\n";
