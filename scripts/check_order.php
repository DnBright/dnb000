<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;

$id = $argv[1] ?? 668;
$order = Order::find((int)$id);
if (! $order) {
    echo "Order not found: $id\n";
    exit(1);
}

echo json_encode([
    'id' => $order->id,
    'status' => $order->status,
    'payment_status' => $order->payment_status,
    'amount' => $order->amount,
    'updated_at' => (string)$order->updated_at,
    'meta' => $order->meta,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
echo "\n";
