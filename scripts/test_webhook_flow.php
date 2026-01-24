<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;

// pick a pending order (or pass id as arg)
$id = $argv[1] ?? null;
if (! $id) {
    $order = Order::where(function($q){ $q->whereNull('payment_status')->orWhere('payment_status','pending'); })->orderBy('id','desc')->first();
} else {
    $order = Order::find((int)$id);
}

if (! $order) {
    echo "No pending order found\n";
    exit(1);
}

$midId = 'DNB-' . $order->id . '-' . time();
$order->meta = array_merge($order->meta ?? [], ['midtrans_order_id' => $midId]);
$order->save();

echo "Attached midtrans_order_id={$midId} to order {$order->id}\n";

// send local POST to webhook
$payload = [
    'order_id' => $midId,
    'transaction_status' => 'settlement',
    'status_code' => '200',
    'gross_amount' => (int)$order->amount,
];

$ch = curl_init('http://127.0.0.1:8000/api/midtrans/notification');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
$res = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "HTTP: {$info['http_code']}\n";
echo "Response: {$res}\n";

// reload order
$order = Order::find($order->id);
echo json_encode([
    'id' => $order->id,
    'status' => $order->status,
    'payment_status' => $order->payment_status,
    'meta' => $order->meta,
    'updated_at' => (string)$order->updated_at,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
